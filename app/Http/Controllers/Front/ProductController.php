<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        return view('front.product', ['product' => $product]);
    }
}
