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
        Route::get('/', 'HomeController@index');

        /*Route::get('update_product', function(){
            return 'hello world';
        });

        Route::post('add_product', 'Admin\IndexController@store');

        Route::delete('delete_product/{product}', 'Admin\IndexController@remove');*/
    });
});

Route::namespace('Front')->group(function() {
    Route::get('/', 'HomeController@index');

    Route::get("section/{section}", 'SectionController@show')->name('front.section.id');
    Route::get("{product}", 'ProductController@show')->name('front.product.id');

    //Route::get("{product}", 'CartController@show')->name('front.product.id');
});
