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

    /**
     * User Profile
     */

    Route::get('/admin/profile/sessions', [
        'as' => 'admin.profile.sessions',
        'uses' => 'ProfileController@sessions'
    ]);

     /**
     * User Management
     */
    Route::get('/admin/user', [
        'as' => 'admin.user.list',
        'uses' => 'Admin\UsersController@index'
    ]);
    
    Route::get('/admin/user/create', [
        'as' => 'admin.user.create',
        'uses' => 'Admin\UsersController@create'
    ]);

    Route::post('/admin/user/create', [
        'as' => 'admin.user.store',
        'uses' => 'Admin\UsersController@store'
    ]);

    Route::delete('user/{user}/delete', [
        'as' => 'admin.user.delete',
        'uses' => 'Admin\UsersController@delete'
    ]);

    Route::get('/admin/user/{user}/edit', [
        'as' => 'admin.user.edit',
        'uses' => 'Admin\UsersController@edit'
    ]);

    Route::get('/admin/user/{user}/show', [
        'as' => 'admin.user.show',
        'uses' => 'Admin\UsersController@view'
    ]);

    Route::put('/admin/user/{user}/update/details', [
        'as' => 'admin.user.update.details',
        'uses' => 'Admin\UsersController@updateDetails'
    ]);

    Route::put('/admin/user/{user}/update/login-details', [
        'as' => 'admin.user.update.login-details',
        'uses' => 'Admin\UsersController@updateLoginDetails'
    ]);
    Route::post('/admin/user/{user}/update/avatar', [
        'as' => 'admin.user.update.avatar',
        'uses' => 'Admin\UsersController@updateAvatar'
    ]);
    Route::post('/admin/user/{user}/update/avatar/external', [
        'as' => 'admin.user.update.avatar.external',
        'uses' => 'Admin\UsersController@updateAvatarExternal'
    ]);

    Route::post('/admin/user/{user}/update/social-networks', [
        'as' => 'admin.user.update.socials',
        'uses' => 'Admin\UsersController@updateSocialNetworks'
    ]);

    Route::get('/admin/user/{user}/sessions', [
        'as' => 'admin.user.sessions',
        'uses' => 'Admin\UsersController@sessions'
    ]);
    Route::delete('/admin/user/{user}/sessions/{session}/invalidate', [
        'as' => 'admin.user.sessions.invalidate',
        'uses' => 'Admin\UsersController@invalidateSession'
    ]);

     /**
     * Activity Log
     */

    Route::get('/admin/activity', [
        'as' => 'admin.activity.index',
        'uses' => 'Admin\ActivityController@index'
    ]);
});


