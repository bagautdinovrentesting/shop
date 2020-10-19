<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\PropertyValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Section;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    public function show(Section $section)
    {
        $this->setViewData($section, $products, $properties);

        return view('front.section', ['section' => $section, 'products' => $products, 'properties' => $properties, 'checked' => []]);
    }

    private function setViewData($section, &$products, &$properties)
    {
        $products = $section->products()->where('status', 1)->paginate(12);

        $propertyValues = PropertyValue::whereHas('products', function (Builder $query) use ($section) {
            $query->where('section_id', $section->id)->where('status', 1);
        })->with('property')->orderBy('sort')->get();

        $properties = array();

        foreach ($propertyValues as $value)
        {
            if (empty($properties[$value->property->id]))
                $properties[$value->property->id] = $value->property->toArray();

            $properties[$value->property->id]['values'][] = $value;
        }
    }

    public function filter(Section $section, Request $request)
    {
        $filterProperties = [];

        foreach ($request->all() as $paramName => $paramValue)
        {
            if (Str::startsWith($paramName, 'p_'))
            {
                $propertyId = Str::substr($paramName, 2);
                $filterProperties[$propertyId] = explode(',', $paramValue);
            }
        }

        if (!empty($filterProperties))
        {
            $query = PropertyValue::with('property');

            $query->whereHas('products', function (Builder $query) use ($section) {
                $query->where('section_id', $section->id)->where('status', 1);
            });

            $query->where( function (Builder $query) use ($filterProperties) {
                $query->whereHas('products', function (Builder $query) use ($filterProperties) {
                    foreach ($filterProperties as $property)
                    {
                        $query->whereHas('values', function (Builder $query) use ($property) {
                            $query->whereIn('property_values.id', $property);
                        });
                    }
                });

                foreach ($filterProperties as $propertyIndex => $property)
                {
                    $query->orWhereHas('property', function (Builder $query) use ($propertyIndex){
                        $query->where('id',  $propertyIndex);
                    });
                }
            });

            $propertyValues = $query->orderBy('sort')->get();

            $properties = array();

            foreach ($propertyValues as $value)
            {
                if (empty($properties[$value->property->id]))
                    $properties[$value->property->id] = $value->property->toArray();

                $properties[$value->property->id]['values'][] = $value;
            }

            $properties = array_sort($properties, function($value)
            {
                return $value['sort'];
            });

            $queryProducts = $section->products()->where('status', 1);

            $queryProducts->where(function (Builder $query) use ($filterProperties) {
                foreach ($filterProperties as $property)
                {
                    $query->WhereHas('values', function (Builder $query) use ($property) {
                        $query->whereIn('property_values.id', $property);
                    });
                }
            });

            $products = $queryProducts->paginate(12);
        }
        else
        {
            $this->setViewData($section, $products, $properties);
        }

        if ($request->has('ajax'))
            return view('front.section_content', ['section' => $section, 'products' => $products->appends($request->except('page', 'ajax')), 'properties' => $properties, 'checked' => $filterProperties]);
        else
            return view('front.section', ['section' => $section, 'products' => $products->appends($request->except('page')), 'properties' => $properties, 'checked' => $filterProperties]);
    }
}
