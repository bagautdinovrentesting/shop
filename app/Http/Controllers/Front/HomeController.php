<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use App\Property;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    public function index()
    {
        $agent = new Agent();

        $properties = Property::with('products')->whereIn('slug', ['novinki', 'xity-prodaz', 'v-trende'])->get();

        return view('front.main', ['showBanner' => true, 'agent' => $agent, 'mainPage' => true, 'properties' => $properties]);
    }
}
