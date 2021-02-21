<?php

namespace App\Services\Section;

use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SectionService
{
    public function getViewData(Section $section, int $page = 1): array
    {
        $cacheKey = "section_filter_properties_{$section->id}" . "_page_$page";

        if (!Cache::tags("section_{$section->id}")->has($cacheKey)) {
            $viewData = compact('section');

            $viewData['products'] = $section->products()->where('status', 1)->paginate(12);

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
                    ['products.status', 1],
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

    public function getViewDataByFilter(
        Section $section,
        array $filterProps,
        array $filterValues,
        int $page
    ): array {
        $cacheKey = "section_filter_properties_{$section->id}_" . implode('_', $filterProps) . '_' . implode('_',
                $filterValues) . "_page_$page";

        if (!Cache::tags("section_{$section->id}")->has($cacheKey)) {
            $viewData = compact('section');

            $viewData['products'] = DB::table('products')->select([
                'products.*',
            ])
                ->join('property_value_product as prod_values', 'products.id', '=', 'prod_values.product_id')
                ->join('property_values as values', 'prod_values.property_value_id', '=', 'values.id')
                ->whereIn('values.id', $filterValues)
                ->where([
                    ['products.section_id', $section->id],
                    ['products.status', 1],
                ])->paginate(12);

            $dbProducts = DB::table('products')->select([
                'products.id',
            ])
                ->join('property_value_product as prod_values', 'products.id', '=', 'prod_values.product_id')
                ->join('property_values as values', 'prod_values.property_value_id', '=', 'values.id')
                ->whereIn('values.id', $filterValues)
                ->where([
                    ['products.section_id', $section->id],
                    ['products.status', 1],
                ])->get();

            $productsIds = $dbProducts->pluck('id');

            $dbProperties = DB::table('products')->select([
                'values.value',
                'values.id as value_id',
                'prop.name',
                'prop.id as prop_id'
            ])
                ->join('property_value_product as prod_values', 'products.id', '=', 'prod_values.product_id')
                ->join('property_values as values', 'prod_values.property_value_id', '=', 'values.id')
                ->join('properties as prop', 'values.property_id', '=', 'prop.id')
                ->whereIn('prop.id', $filterProps)
                ->orWhereIn('products.id', $productsIds)
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
