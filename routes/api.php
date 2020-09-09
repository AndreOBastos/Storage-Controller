<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/products', 'ProductController@index');
Route::get('/products_history', 'ProductController@history');
Route::get('/products/{id}', 'ProductController@show');
Route::post('/products', 'ProductController@store');
Route::post('/many_products', 'ProductController@storeAll');
Route::match(['put', 'patch'], '/products/{id}', 'ProductController@updateProduct');
Route::delete('/products/{id}', 'ProductController@delete');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
