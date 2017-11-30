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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'matrix'], function() {
    Route::get('/syncdata', 'ApiController@index');
    Route::get('/StoreProductsData', 'ApiController@StoreProductsData');
    Route::get('/StoreOrdersData', 'ApiController@StoreOrdersData');
    Route::get('/StoreCustomersData', 'ApiController@StoreCustomersData');
    Route::get('/StoreCategoryData', 'ApiController@StoreCategoryData');
});