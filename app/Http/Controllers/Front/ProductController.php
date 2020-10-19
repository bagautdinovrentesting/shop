<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\ReviewStatus;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $product = Product::with('section', 'values', 'values.property', 'values.property.group')->findOrFail($id);

        $groups = array();

        foreach ($product->values->sortBy('property.sort')->sortBy('property.group.sort') as $value)
        {
            $arProperty = ['name' => $value->property->name, 'value' => $value->value];
            $groups[$value->property->group->name][] = $arProperty;
        }

        $reviews = $product->reviews()->with('user', 'status')->get();

        $reviews = $reviews->filter(function ($value, $key) {
            return $value->status->code === 'S';
        });

        return view('front.product', ['product' => $product, 'groups' => $groups, 'reviews' => $reviews]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        if ($request->has('query'))
        {
            $products = Product::search($request->input('query'))->paginate(12);
        }
        else
        {
            abort(404);
        }

        return view('front.search', ['products' => $products]);
    }
}
