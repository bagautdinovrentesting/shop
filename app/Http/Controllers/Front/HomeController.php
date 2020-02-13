<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    public function index()
    {
        $agent = new Agent();

        $randomProducts = Product::all()->random(4);

        return view('front.main', ['products' => $randomProducts, 'showBanner' => true, 'agent' => $agent, 'mainPage' => true]);
    }
}
