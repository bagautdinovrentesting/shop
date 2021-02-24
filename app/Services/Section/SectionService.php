<?php

namespace App\Services\Section;

use App\Product;
use App\Section;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SectionService
{
    public function getViewData(Section $section, int $page = 1): array
    {
        $cacheKey = "section_filter_properties_{$section->id}" . "_page_$page";

        //Cache::tags("section_{$section->id}")->forget($cacheKey);

        if (!Cache::tags("section_{$section->id}")->has($cacheKey)) {
            $viewData = compact('section');

            $viewData['products'] = $section->products()->where('status', Product::STATUS_ACTIVE)->paginate(72);

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
                $properties[$property->prop_id]['values'][$property->value_id] = $property->value;
            }

            $viewData['properties'] = $properties;

            Cache::tags("section_{$section->id}")->put($cacheKey, $viewData);
        } else {
            $viewData = Cache::tags("section_{$section->id}")->get($cacheKey);
        }

        return $viewData;
    }

    public function getViewDataByFilter(Section $section, array $filterProperties, int $page): array
    {
        $filterValues = array_reduce($filterProperties, function ($carry, $item) {
            return array_merge($carry, $item);
        }, []);

        $cacheKey = "section_filter_properties_{$section->id}_"
            . implode('_', array_keys($filterProperties)) . '_'
            . implode('_', $filterValues)
            . "_page_$page";

        //Cache::tags("section_{$section->id}")->forget($cacheKey);

        if (!Cache::tags("section_{$section->id}")->has($cacheKey)) {
            $viewData = compact('section');

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

            $productIds = $productQuery->get()->pluck('id');

            $viewData['products'] = DB::table('products')
                ->whereIn('id', $productIds)
                ->paginate(72);

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
                $properties[$property->prop_id]['values'][$property->value_id] = $property->value;
            }

            $viewData['properties'] = $properties;

            Cache::tags("section_{$section->id}")->put($cacheKey, $viewData);
        } else {
            $viewData = Cache::tags("section_{$section->id}")->get($cacheKey);
        }

        return $viewData;
    }
}
