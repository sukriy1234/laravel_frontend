<?php

Route::get('/', 'UserController@index');

Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::get('/user/search', 'UserController@search');

//PRODUCT
Route::prefix('product')->group(function () {
    Route::post('', 'ProductController@index');
    Route::post('view', 'ProductController@view');
    Route::post('store', 'ProductController@store');
    Route::post('delete', 'ProductController@delete');
    Route::post('update', 'ProductController@update');
    Route::get('search', 'ProductController@search');
});

Route::prefix('order')->group(function () {
    //ORDER CRUD
    Route::post('', 'OrderController@index');
    Route::post('view', 'OrderController@view');
    Route::post('store', 'OrderController@store');
    Route::post('delete', 'OrderController@delete');
    Route::post('update', 'OrderController@update');

    //ORDER VALIDATION
    Route::post('reporter', 'OrderController@reporter');
    Route::post('update_finance', 'OrderController@update_finance');
    Route::post('update_finance', 'OrderController@update_finance');
});

Route::get('{any}', function () {
    return view('home');
})->where('any', '.*');
