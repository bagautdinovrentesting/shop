<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Contracts\MathHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Product;

class DiffMathController extends Controller
{
    protected MathHelper $mathHelper;

    public function __construct(MathHelper $mathHelper)
    {
        $this->mathHelper = $mathHelper;
    }

    public function calculate()
    {
        $arProductsByUser = array();

        if (Cache::has('products_by_user'))
        {
            $arProductsByUser = json_decode(Cache::get('products_by_user'));
        }
        else
        {
            $products = Product::all();

            foreach ($products as $product)
            {
                $arProductsByUser[$product->user->name][] = $product->name;
            }

            Cache::put('products_by_user', json_encode($arProductsByUser), Carbon::now()->addHour());
        }

        dd($arProductsByUser);
        return $this->mathHelper->calculate(3, 5);
    }
}
