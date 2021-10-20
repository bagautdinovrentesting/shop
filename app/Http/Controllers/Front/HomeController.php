<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use App\Property;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    private $propertySlugs = [
        'novinki',
        'xity-prodaz',
        'v-trende'
    ];

    public function index()
    {
        $agent = new Agent();
        $properties = [];

        foreach ($this->propertySlugs as $slug) {
            $products = DB::table('properties as prop')->select(['prop.name as prop_name', 'products.*'])->take(10)
                ->join('property_value_product as prod_value', 'prop.id', '=', 'prod_value.property_id')
                ->join('products', 'prod_value.product_id', '=', 'products.id')
                ->where('prop.slug', $slug)->get()->groupBy('prop_name')->toArray();

            $properties[key($products)] = collect($products[key($products)]);
        }


        return view('front.main', ['showBanner' => true, 'agent' => $agent, 'mainPage' => true, 'properties' => $properties]);
    }
}
