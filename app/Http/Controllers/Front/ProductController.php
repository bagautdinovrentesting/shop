<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
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

        foreach ($product->values as $value)
        {
            $arProperty = ['name' => $value->property->name, 'value' => $value->value];
            $groups[$value->property->group->name][] = $arProperty;
        }

        return view('front.product', ['product' => $product, 'groups' => $groups]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        if ($request->has('query'))
        {
            $products = Product::search($request->input('query'))->paginate(4);
        }
        else
        {
            $products = Product::paginate(4);
        }

        return view('front.search', ['products' => $products]);
    }
}
