<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('admin')->group(function(){
    Route::get('/create', 'productController@create')->name('create');
    Route::post('create', 'productController@showForm')->name('createForm');
    Route::get('/update/{id}', 'productController@UpdateForm')->name('UpdateForm');
    Route::patch('/update/{id}', 'productController@ShowUpdateForm')->name('Update');
    Route::delete('/delete/{id}', 'productController@DeleteProduct')->name('DeleteProduct');
});

Route::middleware('auth')->group(function(){
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/view/{id}', 'productController@ViewProduct')->name('ViewProduct');
    Route::get('/cart', 'cartController@index')->name('cart.index');
    Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
    Route::patch('/cart/{product}', 'cartController@update')->name('cart.update');
    Route::delete('/cart/{product}', 'cartController@destroy')->name('cart.destroy');
    Route::post('/cart/{product}', 'cartController@store')->name('cart.store');
});

