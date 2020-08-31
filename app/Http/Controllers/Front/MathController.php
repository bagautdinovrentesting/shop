<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use App\Services\Contracts\MathHelper;
use Illuminate\Http\Request;

class MathController extends Controller
{
    protected MathHelper $mathHelper;

    public function __construct(MathHelper $mathHelper)
    {
        $this->mathHelper = $mathHelper;
    }

    public function calculate(Request $request, $city = '')
    {
        $products = Product::where('status', '=', 1)->with('user')->dd();


        dd(config()->all());
        //return $this->mathHelper->calculate(3, 5);
    }
}
