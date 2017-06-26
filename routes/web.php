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

Route::get('/','HomeController@index');

Route::get('/product/{product}','ProductController@show');

Route::get('/category/{category}','CategoryController@show');

Route::get('/cart','cartController@index');

Route::get('/admin/login', 'Auth\AuthController@getLogin');

Route::post('/admin/login', 'Auth\AuthController@postLogin');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin', [
        'as' => 'dashboard',
        'uses' => 'DashboardController@index'
    ]);
    Route::get('/admin/user', [
        'as' => 'user.list',
        'uses' => 'Admin\UsersController@index'
    ]);
});


