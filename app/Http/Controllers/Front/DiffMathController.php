<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use App\Services\Contracts\MathHelper;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Order;

class DiffMathController extends Controller
{
    protected MathHelper $mathHelper;

    public function __construct(MathHelper $mathHelper)
    {
        $this->mathHelper = $mathHelper;
    }

    public function calculate()
    {
        $products = Product::all();

        foreach ($products as $product)
        {
            var_dump($product->toJson(JSON_UNESCAPED_UNICODE));
        }
        //$products->toQuery()->update(['status' => 1]);

        die();

        if (Cache::has('products_by_user'))
        {
            $arProductsByUser = json_decode(Cache::get('products_by_user'));
        }
        else
        {
            $arProductsByUser = User::with('products')->get();

            Cache::put('products_by_user', json_encode($arProductsByUser), Carbon::now()->addHour());
        }

        dd($arProductsByUser);
        return $this->mathHelper->calculate(3, 5);
    }
}
