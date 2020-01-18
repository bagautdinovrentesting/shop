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

Route::get('/', function (Request $request) {
    //request()->session()->forget('status');
    return view('welcome');
});

Auth::routes();

Route::prefix('admin')->middleware('check.role')->group(function(){
    Route::get('/', 'Admin\IndexController@index');

    Route::get('update_product', function(){
        return 'hello world';
    });

    Route::post('add_product', 'Admin\IndexController@store');

    Route::delete('delete_product/{product}', 'Admin\IndexController@remove');
});
