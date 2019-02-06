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

Route::get('/', 'UserController@index');
Route::get('/coba', 'UserController@coba');

Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::get('/user/search', 'UserController@search');

//PRODUCT CRUD
Route::post('/product', 'ProductController@index');
Route::post('/product/view', 'ProductController@view');
Route::post('/product/store', 'ProductController@store');
Route::post('/product/delete', 'ProductController@delete');
Route::post('/product/update', 'ProductController@update');
Route::get('/product/search', 'ProductController@search');


//ORDER CRUD
Route::post('/order', 'OrderController@index');
Route::post('/order/view', 'OrderController@view');
Route::post('/order/store', 'OrderController@store');
Route::post('/order/delete', 'OrderController@delete');
Route::post('/order/update', 'OrderController@update');



//ORDER VALIDATION
Route::post('/order/reporter', 'OrderController@reporter');
Route::post('/order/update_finance', 'OrderController@update_finance');
Route::post('/order/update_finance', 'OrderController@update_finance');


Route::get('{any}', function () {
    return view('home');
})->where('any', '.*');
