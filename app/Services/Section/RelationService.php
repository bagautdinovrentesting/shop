<?php

namespace App\Services\Section;

use App\Product;
use App\Section;

use App\Services\Elastic\ProductSearch;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RelationService implements Contracts\SectionService
{
    public function getViewData(Section $section, int $perPage, int $currentPage): array
    {
        $cacheKey = "section_filter_properties_{$section->id}" . "_page_$currentPage";

        Cache::tags("section_{$section->id}")->forget($cacheKey);

        if (!Cache::tags("section_{$section->id}")->has($cacheKey)) {
            $viewData = compact('section');

            $viewData['checked'] = [];
            $viewData['products'] = $this->getProducts($section, $perPage);
            $viewData['properties'] = $this->getProperties($section);

            Cache::tags("section_{$section->id}")->put($cacheKey, $viewData);
        } else {
            $viewData = Cache::tags("section_{$section->id}")->get($cacheKey);
        }

        return $viewData;
    }

    public function getProducts(Section $section, int $perPage) : LengthAwarePaginator
    {
        return $section->products()->active()->paginate($perPage);
    }

    public function getProperties(Section $section) : array
    {
        $dbProperties = DB::table('products')->select([
            'products.id as product_id',
            'values.value',
            'values.id as value_id',
            'prop.name',
            'prop.id as prop_id'
        ])
            ->join('property_value_product as prod_values', 'products.id', '=', 'prod_values.product_id')
            ->join('property_values as values', 'prod_values.property_value_id', '=', 'values.id')
            ->join('properties as prop', 'values.property_id', '=', 'prop.id')
            ->where([
                ['products.section_id', $section->id],
                ['products.status', Product::STATUS_ACTIVE],
            ])->orderBy('prop.sort')->orderBy('values.sort')->get();

        $properties = [];

        foreach ($dbProperties as $property) {
            $properties[$property->prop_id]['name'] = $property->name;
            $properties[$property->prop_id]['values'][$property->value_id] = ['value' => $property->value];
        }

        return $properties;
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

            $productIds = $this->getProductsWithFilter($section, $filterProperties);

            $viewData['products'] = DB::table('products')
                ->whereIn('id', $productIds)
                ->paginate($perPage)
                ->appends($request->except('page', 'ajax'));

            $viewData['properties'] = $this->getPropertiesWithFilter($section, $filterProperties, $productIds);

            Cache::tags("section_{$section->id}")->put($cacheKey, $viewData);
        } else {
            $viewData = Cache::tags("section_{$section->id}")->get($cacheKey);
        }

        return $viewData;
    }

    public function getProductsWithFilter(Section $section, array $filterProperties) : Collection
    {
        $productQuery = DB::table('products')->select('products.id')->distinct()
            ->join('property_value_product as prod_values', 'products.id', '=', 'prod_values.product_id')
            ->where([
                ['products.section_id', $section->id],
                ['products.status', Product::STATUS_ACTIVE],
            ])
            ->where(function ($query) use ($filterProperties) {
                foreach ($filterProperties as $values) {
                    $query->whereIn('products.id', function ($innerQuery) use ($values) {
                        $innerQuery->select('prod_values.product_id')
                            ->from('property_value_product as prod_values')
                            ->whereIn('prod_values.property_value_id', $values);
                    });
                }
            });

        return $productQuery->get()->pluck('id');
    }

    public function getPropertiesWithFilter(Section $section, array $filterProperties, Collection $productIds) : array
    {
        $arPropFilter = [];

        foreach (array_keys($filterProperties) as $propertyId) {
            $productQuery = DB::table('products')->select('products.id')->distinct()
                ->join('property_value_product as prod_values', 'products.id', '=', 'prod_values.product_id')
                ->where([
                    ['products.section_id', $section->id],
                    ['products.status', Product::STATUS_ACTIVE],
                ])
                ->where(function ($query) use ($filterProperties, $propertyId) {
                    foreach ($filterProperties as $innerPropertyId => $values) {

                        if ($propertyId === $innerPropertyId) {
                            continue;
                        }
                        $query->whereIn('products.id', function ($innerQuery) use ($values) {
                            $innerQuery->select('prod_values.product_id')
                                ->from('property_value_product as prod_values')
                                ->whereIn('prod_values.property_value_id', $values);
                        });
                    }
                });

            $arPropFilter[$propertyId] = $productQuery->get()->pluck('id');
        }

        $dbProperties = DB::table('products')->select([
            'values.value',
            'values.id as value_id',
            'prop.name',
            'prop.id as prop_id'
        ])
            ->join('property_value_product as prod_values', 'products.id', '=', 'prod_values.product_id')
            ->join('property_values as values', 'prod_values.property_value_id', '=', 'values.id')
            ->join('properties as prop', 'values.property_id', '=', 'prop.id')
            ->whereIn('products.id', $productIds)
            ->orWhere(function ($query) use ($arPropFilter) {
                foreach ($arPropFilter as $propertyId => $productIds) {
                    $query->orWhere(function ($innerQuery) use ($propertyId, $productIds) {
                        $innerQuery->where('prop.id', $propertyId)
                            ->whereIn('products.id', $productIds);
                    });
                }
            })
            ->orderBy('prop.sort')->orderBy('values.sort')
            ->groupBy('values.id')->get();

        $properties = [];

        foreach ($dbProperties as $property) {
            $properties[$property->prop_id]['name'] = $property->name;
            $properties[$property->prop_id]['values'][$property->value_id] = ['value' => $property->value];
        }

        return $properties;
    }
}
