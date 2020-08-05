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

Route::get('/home', function () {
    return redirect('/');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/product/{id}', 'ProductController@index');

Route::get('/product/{id}/order', 'ProductController@order');

Route::get('/product/{id}/checkout', 'ProductController@checkout');



