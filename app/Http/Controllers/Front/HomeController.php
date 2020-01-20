<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    public function index()
    {
        $randomProducts = Product::all()->random(1);

        return view('front.main', ['products' => $randomProducts]);
    }
}