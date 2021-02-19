<?php

namespace App\Providers;

use App\Observers\ProductObserver;
use App\Product;
use Illuminate\Support\ServiceProvider;
use App\Section;
use App\Cart;
use App\Http\Controllers\Front\MathController;
use App\Http\Controllers\Front\DiffMathController;
use App\Services\Contracts\MathHelper;
use App\Services\SumMathHelper;
use App\Services\DiffMathHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*DB::listen(function ($query) {
            echo '<pre>';
            var_dump(
                $query->sql,
                $query->bindings,
                $query->time
            );
            echo '</pre>';
        });*/

        $dbSections = Section::where('depth_level', '<', '4')->get();
        $arNestedSections = [];

        foreach ($dbSections as $section) {
            $arNestedSections[$section['parent_id']][$section['id']] = $section->toArray();
        }

        view()->composer(['layouts.front.app'], function ($view) use ($arNestedSections) {
            $view->with('sections', $this->recursiveBuildTree($arNestedSections, ''));
            $view->with('cartCounts', $this->getCartCounts());
        });
    }

    public function recursiveBuildTree($arItems, $parentId)
    {
        $arSections = [];

        if (is_array($arItems) && !empty($arItems[$parentId])) {
            foreach ($arItems[$parentId] as $item) {
                $arSections[$item['id']] = $item;
                $arSections[$item['id']]['children'] = $this->recursiveBuildTree($arItems, $item['id']);
            }
        } else {
            return null;
        }

        return $arSections;
    }

    public function getCartCounts()
    {
        $cart = new Cart();

        return $cart->count();
    }
}
