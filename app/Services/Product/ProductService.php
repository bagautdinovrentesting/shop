<?php

namespace App\Services\Product;

use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function updateProduct(ProductRequest $request, Product $product)
    {
        $productData = $this->getExtraProductData($request);

        DB::transaction(function () use ($request, $product, $productData) {
            $this->saveProductProperties($request, $product);

            $product->update($productData);
        });
    }

    public function createProduct(ProductRequest $request)
    {
        $productData = $this->getExtraProductData($request);

        DB::transaction(function () use ($request, $productData) {
            $product = Product::create($productData);

            $this->saveProductProperties($request, $product);
        });
    }

    public function getExtraProductData(ProductRequest $request) : array
    {
        $productData = Arr::except($request->validated(), ['properties', 'detail_photo', 'preview_photo']);

        if ($request->hasFile('preview_photo')) {
            $productData['preview_photo'] = $request->file('preview_photo')->store('products', ['disk' => 'public']);
        }

        if ($request->hasFile('detail_photo')) {
            $productData['detail_photo'] = $request->file('detail_photo')->store('products', ['disk' => 'public']);
        }

        $productData['user_id'] = $request->user()->id;

        return $productData;
    }

    public function saveProductProperties(ProductRequest $request, Product $product) : void
    {
        if ($request->has('properties'))
        {
            $arValues = array();

            foreach($request->properties as $propertyId => $valueId)
            {
                if (!empty($valueId))
                    $arValues[str_random(5)] = ['property_value_id' => $valueId, 'property_id' => $propertyId];
            }

            $product->values()->detach();
            $product->values()->attach($arValues);
        }
    }
}
