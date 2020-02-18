<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::prefix('admin')->middleware('check.role')->as('admin.')->group(function() {
    Route::namespace('Admin')->group(function() {
        Route::get('/', 'HomeController@index')->name('dashboard');

        Route::resource('products', 'ProductController');
        //Route::resource('sections', 'ProductController');
        Route::resource('users', 'UserController');
        Route::get('orders', 'OrderController@index')->name('orders.index');
    });
});

Route::namespace('Front')->group(function() {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get("checkout", 'CheckoutController@index')->name('checkout.index');
    Route::post("checkout", 'CheckoutController@store')->name('checkout.store');

    Route::get("search", 'ProductController@search')->name('front.search');

    Route::resource("cart", 'CartController');

    Route::get("section/{section}", 'SectionController@show')->name('front.section.id');
    Route::get("product/{product}", 'ProductController@show')->name('front.product.id');
});
