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

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::get('/product/{product}', 'App\Http\Controllers\ProductController@show')->name('product.show');
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
