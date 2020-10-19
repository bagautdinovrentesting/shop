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

Auth::routes(['verify' => true]);

Route::prefix('admin')->middleware('dashboard')->as('admin.')->group(function() {
    Route::namespace('Admin')->group(function() {
        Route::get('/', 'HomeController@index')->name('dashboard');

        Route::resource('products', 'ProductController');
        Route::resource('sections', 'SectionController');

        Route::resource('group_properties', 'GroupPropertyController')->except([
            'index', 'show'
        ]);

        Route::resource('reviews', 'ReviewController')->except(['show']);

        Route::resource('properties', 'PropertyController');

        Route::resource('users', 'UserController');
        Route::get('orders', 'OrderController@index')->name('orders.index');
    });
});

Route::domain('{city}.bourne.com')->group(function (){
    Route::namespace('Front')->group(function() {
        Route::get('math', 'MathController@calculate');
    });
});

Route::namespace('Front')->group(function() {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get("checkout", 'CheckoutController@index')->name('checkout.index');
    Route::post("checkout", 'CheckoutController@store')->name('checkout.store');

    Route::get("search", 'ProductController@search')->name('front.search');

    Route::resource("cart", 'CartController');

    Route::get("catalog", 'CatalogController@index')->name('catalog.index');

    Route::get('section/{section}', 'SectionController@show')->name('front.section.id');
    Route::get('product/{product}', 'ProductController@show')->name('front.product.id');
    Route::post('reviews', 'ReviewController@store')->name('front.reviews.store');

    //Route::get('math', 'MathController@calculate');
    //Route::get('diff', 'DiffMathController@calculate');

    Route::get('section/{section}/filter', 'SectionController@filter')->name('front.catalog.filter');

    Route::post('test/{product}', function (\App\Product $product){
        return new \App\Http\Resources\Product($product);
    });
});
