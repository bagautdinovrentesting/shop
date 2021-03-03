<?php

namespace App\Services\Section;

use App\Product;
use App\Property;
use App\PropertyValue;
use App\Section;

use App\Services\Elastic\ProductSearch;
use \Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ElasticService implements Contracts\SectionService
{
    private ProductSearch $searchService;

    public function __construct(ProductSearch $searchService)
    {
        $this->searchService = $searchService;
    }

    public function getViewData(Section $section, int $perPage, int $currentPage): array
    {
        $cacheKey = "section_filter_properties_{$section->id}" . "_page_$currentPage";

        Cache::tags("section_{$section->id}")->forget($cacheKey);

        if (!Cache::tags("section_{$section->id}")->has($cacheKey)) {
            $viewData = compact('section');

            $viewData['checked'] = [];
            $viewData['products'] = $this->getProducts($section, $perPage, $currentPage);
            $viewData['properties'] = $this->getProperties($section);

            Cache::tags("section_{$section->id}")->put($cacheKey, $viewData);
        } else {
            $viewData = Cache::tags("section_{$section->id}")->get($cacheKey);
        }

        return $viewData;
    }

    public function getProducts(Section $section, int $perPage, int $currentPage) : LengthAwarePaginator
    {
        [$productIds, $total] = $this->searchService->productsQuery($section, $perPage, $currentPage);

        if ($productIds) {
            $products = Product::whereIn('id', $productIds)
                ->orderBy(new Expression('FIELD(id,' . implode(',', $productIds) . ')'))
                ->get();
            $pagination = new LengthAwarePaginator($products, $total, $perPage, $currentPage);
        } else {
            $pagination = new LengthAwarePaginator([], 0, $perPage, $currentPage);
        }

        return $pagination->withPath("$section->id");
    }

    public function getProperties(Section $section) : array
    {
        $elasticProperties = $this->searchService->propertyAggregate($section);

        $propertyIds = array_column($elasticProperties, 'key');
        $valueBuckets = array_column($elasticProperties, 'values');

        $elasticValues = [];

        foreach (array_column($valueBuckets, 'buckets') as $bucket) {
            $elasticValues = array_column($bucket, 'doc_count', 'key') + $elasticValues;
        }

        return $this->getPropertyValuesByIds($propertyIds, $elasticValues);
    }

    public function getViewDataWithFilter(Section $section, int $perPage, int $currentPage, Request $request): array
    {
        $filterProperties = [];

        foreach ($request->all() as $paramName => $paramValue) {
            if (Str::startsWith($paramName, 'p_')) {
                $propertyId = Str::substr($paramName, 2);
                $filterProperties[$propertyId] = explode(',', $paramValue);
            }
        }

        if (empty($filterProperties))
            return $this->getViewData($section, $perPage, $currentPage);

        $filterValues = array_reduce($filterProperties, function ($carry, $item) {
            return array_merge($carry, $item);
        }, []);

        $cacheKey = "section_filter_properties_{$section->id}_"
            . implode('_', array_keys($filterProperties)) . '_'
            . implode('_', $filterValues)
            . "_page_$currentPage";

        Cache::tags("section_{$section->id}")->forget($cacheKey);

        if (!Cache::tags("section_{$section->id}")->has($cacheKey)) {
            $viewData = compact('section');

            $viewData['checked'] = $filterProperties;
            $viewData['products'] = $this->getProductsWithFilter($section, $perPage, $currentPage, $filterProperties);
            $viewData['properties'] = $this->getPropertiesWithFilter($section, $filterProperties);

            Cache::tags("section_{$section->id}")->put($cacheKey, $viewData);
        } else {
            $viewData = Cache::tags("section_{$section->id}")->get($cacheKey);
        }

        return $viewData;
    }

    public function getProductsWithFilter(Section $section, int $perPage, int $currentPage, array $filterProperties) : LengthAwarePaginator
    {
        [$productIds, $total] = $this->searchService->productsQueryWithFilter($section, $perPage, $currentPage, $filterProperties);

        if ($productIds) {
            $products = Product::whereIn('id', $productIds)
                ->orderBy(new Expression('FIELD(id,' . implode(',', $productIds) . ')'))
                ->get();
            $pagination = new LengthAwarePaginator($products, $total, $perPage, $currentPage);
        } else {
            $pagination = new LengthAwarePaginator([], 0, $perPage, $currentPage);
        }

        return $pagination->withPath("$section->id");
    }

    public function getPropertiesWithFilter(Section $section, array $filterProperties) : array
    {
        $elasticProperties = $this->searchService->propertyAggregateWithFilter($section, $filterProperties);

        $propertyIds = array_column($elasticProperties['all_props']['facets']['props']['buckets'], 'key');

        $elasticValues = [];

        foreach ($elasticProperties as $propIndex => $property) {
            if ($propIndex === 'all_props') {
                $valueBuckets = array_column($property['facets']['props']['buckets'], 'values');
            } else {
                $valueBuckets = array_column($property['facets']['aggs_special']['props']['buckets'], 'values');
            }

            foreach (array_column($valueBuckets, 'buckets') as $bucket) {
                $elasticValues = array_column($bucket, 'doc_count', 'key') + $elasticValues;
            }
        }

        return $this->getPropertyValuesByIds($propertyIds, $elasticValues);
    }

    private function getPropertyValuesByIds(array $propertyIds, array $valueIds) : array
    {
        $dbProperties = Property::select(['name', 'id', 'sort'])->whereIn('id', $propertyIds)->orderBy('sort')->get()->pluck('name', 'id');
        $dbValues = PropertyValue::select(['value', 'id', 'property_id'])->whereIn('id', array_keys($valueIds))->orderBy('sort')->get()->groupBy('property_id');

        $properties = [];

        foreach ($dbProperties as $propertyId => $propertyName) {
            $properties[$propertyId]['name'] = $propertyName;

            foreach ($dbValues[$propertyId] as $value) {
                $propValue = $value->toArray();
                $propValue['count'] = $valueIds[$value->id];

                $properties[$propertyId]['values'][$value->id] = $propValue;
            }
        }

        return $properties;
    }
}
