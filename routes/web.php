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

Route::prefix('admin')->middleware('check.role')->group(function() {
    Route::namespace('Admin')->group(function() {
        Route::get('/', 'HomeController@index')->name('admin.home');

        //Route::resource('products', 'ProductController');
        //Route::resource('sections', 'ProductController');
        //Route::resource('users', 'ProductController');
        //Route::resource('orders', 'ProductController');
    });
});

Route::namespace('Front')->group(function() {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get("section/{section}", 'SectionController@show')->name('front.section.id');
    Route::get("{product}", 'ProductController@show')->name('front.product.id');

    //Route::resource("cart", 'CartController@show');
    //Route::get("checkout", 'CheckoutController@show');
});
