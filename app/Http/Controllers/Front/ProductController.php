<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSearchRequest;
use App\ReviewStatus;
use App\Services\Elastic\ProductSearch;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    private ProductSearch $searchService;

    public function __construct(ProductSearch $searchService)
    {
        $this->searchService = $searchService;
    }

    public function show($id)
    {
        $product = Product::with('section', 'values', 'values.property', 'values.property.group')->findOrFail($id);

        $groups = array();

        foreach ($product->values->sortBy('property.sort')->sortBy('property.group.sort') as $value)
        {
            $arProperty = ['name' => $value->property->name, 'value' => $value->value];
            $groups[$value->property->group->name][] = $arProperty;
        }

        $reviews = $product->reviews()->with('user', 'status')->get()->sortByDesc('updated_at');

        $reviews = $reviews->filter(function ($value, $key) {
            return $value->status->code === 'S';
        });

        return view('front.product', ['product' => $product, 'groups' => $groups, 'reviews' => $reviews]);
    }

    public function search(ProductSearchRequest $request)
    {
        $products = $this->searchService->search($request, 12);

        return view('front.search', ['products' => $products]);
    }
}
