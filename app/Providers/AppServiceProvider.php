<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Section;
use App\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.front.app'], function ($view) {
            $view->with('sections', Section::all());
            $view->with('cartCounts', $this->getCartCounts());
        });
    }

    public function getCartCounts()
    {
        $cart = new Cart();

        return $cart->count();
    }
}
