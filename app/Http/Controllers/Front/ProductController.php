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
    public function show(Product $product)
    {
        return view('front.product', ['product' => $product]);
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
