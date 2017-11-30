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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware'=>['auth'],'prefix' => 'admin'], function () {
	Route::get('/sync', 'DashboardController@index');
	Route::get('/dashboard', 'DashboardController@dashboard');
	
	// Routes for User 
	Route::get('/profile', 'DashboardController@editprofile');
	Route::post('/updateprofile', 'DashboardController@updateprofile');
	
	// Routes for Customers
	Route::any('/customers', 'CustomersController@index');
	Route::get('/customerstableajax', 'CustomersController@MagentoCustomersTableAjax');
	Route::get('/customers-settings', 'CustomersController@customerssettings');
	Route::post('/update-customers-settings', 'CustomersController@updatecustomerssettings');


	// Routes for Orders
	Route::any('/orders', 'OrdersController@index');
	Route::get('/orderstableajax', 'OrdersController@MagentoOrdersTableAjax');
	Route::get('/orders-settings', 'OrdersController@orderssettings');
	Route::post('/update-orders-settings', 'OrdersController@updateorderssettings');
	Route::get('/orderview/{id}', 'OrdersController@OrderView');

	// Routes for Category
	Route::any('/category', 'CategoryController@index');
});


