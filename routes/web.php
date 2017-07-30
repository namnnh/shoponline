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

Route::get('/demo','DemoController@index');

Route::get('/product/{product}','ProductController@show');

Route::get('/category/{category}','CategoryController@show');

Route::get('/cart','cartController@index');

Route::get('/admin/login', 'Auth\AuthController@getLogin');

Route::post('/admin/login', 'Auth\AuthController@postLogin');

// Alow forgot password routes only if it's enabled
if (settings('forgot_password')) {
    Route::get('/admin/password/remind', 'Auth\PasswordController@forgotPassword');
    Route::post('/admin/password/remind', 'Auth\PasswordController@sendPasswordReminder');
    Route::get('/admin/password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('/admin/password/reset', 'Auth\PasswordController@postReset');
}

// Allow registration routes only if registration is enabled.
if (settings('reg_enabled')) {
    Route::get('/admin/register', 'Auth\AuthController@getRegister');
    Route::post('/admin/register', 'Auth\AuthController@postRegister');
    Route::get('/admin/register/confirmation/{token}', [
        'as' => 'admin.register.confirm-email',
        'uses' => 'Auth\AuthController@confirmEmail'
    ]);
}

Route::get('logout', [
    'as' => 'auth.logout',
    'uses' => 'Auth\AuthController@getLogout'
]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin', [
        'as' => 'dashboard',
        'uses' => 'DashboardController@index'
    ]);

    Route::get('/admin/media', [
        'as' => 'admin.media.index',
        'uses' => 'Admin\MediaController@index'
    ]);

    /**
    * Category
    */

    Route::get('/admin/category',[
        'as' => 'admin.category',
        'uses' => 'Admin\CategoriesController@index'
    ]);

    Route::get('/admin/category/create', [
        'as' => 'admin.category.create',
        'uses' => 'Admin\CategoriesController@create'
    ]);

    Route::post('/admin/category/create', [
        'as' => 'admin.category.store',
        'uses' => 'Admin\CategoriesController@store'
    ]);

    Route::put('/admin/category/{category}/update', [
        'as' => 'admin.category.update',
        'uses' => 'Admin\CategoriesController@update'
    ]);

    Route::get('/admin/category/{category}/edit', [
        'as' => 'admin.category.edit',
        'uses' => 'Admin\CategoriesController@edit'
    ]);

    /**
     * User Profile
     */

    Route::get('/admin/profile/sessions', [
        'as' => 'admin.profile.sessions',
        'uses' => 'ProfileController@sessions'
    ]);

    Route::put('/admin/user/{user}/update/details', [
        'as' => 'admin.user.update.details',
        'uses' => 'Admin\UsersController@updateDetails'
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
     * User Profile
     */

    Route::get('admin/profile', [
        'as' => 'admin.profile',
        'uses' => 'Admin\ProfileController@index'
    ]);

    Route::get('admin/profile/activity', [
        'as' => 'admin.profile.activity',
        'uses' => 'Admin\ProfileController@activity'
    ]);

    Route::put('admin/profile/details/update', [
        'as' => 'admin.profile.update.details',
        'uses' => 'Admin\ProfileController@updateDetails'
    ]);

    Route::post('admin/profile/avatar/update', [
        'as' => 'admin.profile.update.avatar',
        'uses' => 'Admin\ProfileController@updateAvatar'
    ]);

    Route::post('admin/profile/avatar/update/external', [
        'as' => 'admin.profile.update.avatar-external',
        'uses' => 'Admin\ProfileController@updateAvatarExternal'
    ]);

    Route::put('admin/profile/login-details/update', [
        'as' => 'admin.profile.update.login-details',
        'uses' => 'Admin\ProfileController@updateLoginDetails'
    ]);

    Route::put('admin/profile/social-networks/update', [
        'as' => 'admin.profile.update.social-networks',
        'uses' => 'Admin\ProfileController@updateSocialNetworks'
    ]);

    Route::get('admin/profile/sessions', [
        'as' => 'admin.profile.sessions',
        'uses' => 'Admin\ProfileController@sessions'
    ]);

    Route::delete('admin/profile/sessions/{session}/invalidate', [
        'as' => 'admin.profile.sessions.invalidate',
        'uses' => 'Admin\ProfileController@invalidateSession'
    ]);

     /**
     * Activity Log
     */

    Route::get('/admin/activity', [
        'as' => 'admin.activity.index',
        'uses' => 'Admin\ActivityController@index'
    ]);

    Route::get('/admin/activity/user/{user}/log', [
        'as' => 'admin.activity.user',
        'uses' => 'Admin\ActivityController@userActivity'
    ]);

     /**
     * Roles & Permissions
     */
    Route::get('/admin/role', [
        'as' => 'admin.role.index',
        'uses' => 'Admin\RolesController@index'
    ]);
    Route::get('/admin/role/create', [
        'as' => 'admin.role.create',
        'uses' => 'Admin\RolesController@create'
    ]);

    Route::post('/admin/role/store', [
        'as' => 'admin.role.store',
        'uses' => 'Admin\RolesController@store'
    ]);

    Route::get('/admin/role/{role}/edit', [
        'as' => 'admin.role.edit',
        'uses' => 'Admin\RolesController@edit'
    ]);

    Route::put('/admin/role/{role}/update', [
        'as' => 'admin.role.update',
        'uses' => 'Admin\RolesController@update'
    ]);

    Route::delete('/admin/role/{role}/delete', [
        'as' => 'admin.role.delete',
        'uses' => 'Admin\RolesController@delete'
    ]);

    Route::post('admin/permission/save', [
        'as' => 'admin.permission.save',
        'uses' => 'Admin\PermissionsController@saveRolePermissions'
    ]);

    Route::resource('admin/permission', 'Admin\PermissionsController',['names' => [
        'index' => 'admin.permission.index',
        'create' => 'admin.permission.create',
        'edit' => 'admin.permission.edit',
        'update' => 'admin.permission.update',
        'destroy' => 'admin.permission.destroy',
        'store' => 'admin.permission.store'
    ]]);

    /**
     * Settings
     */

    Route::get('admin/settings', [
        'as' => 'admin.settings.general',
        'uses' => 'Admin\SettingsController@general',
        'middleware' => 'permission:settings.general'
    ]);

    Route::post('admin/settings/general', [
        'as' => 'admin.settings.general.update',
        'uses' => 'Admin\SettingsController@update',
        'middleware' => 'permission:settings.general'
    ]);

    Route::get('admin/settings/auth', [
        'as' => 'admin.settings.auth',
        'uses' => 'Admin\SettingsController@auth',
        'middleware' => 'permission:settings.auth'
    ]);

    Route::post('admin/settings/auth', [
        'as' => 'admin.settings.auth.update',
        'uses' => 'Admin\SettingsController@update',
        'middleware' => 'permission:settings.auth'
    ]);

    Route::post('admin/settings/auth/registration/captcha/enable', [
        'as' => 'admin.settings.registration.captcha.enable',
        'uses' => 'Admin\SettingsController@enableCaptcha',
        'middleware' => 'permission:settings.auth'
    ]);

    Route::post('admin/settings/auth/registration/captcha/disable', [
        'as' => 'admin.settings.registration.captcha.disable',
        'uses' => 'Admin\SettingsController@disableCaptcha',
        'middleware' => 'permission:settings.auth'
    ]);

    Route::get('admin/settings/notifications', [
        'as' => 'admin.settings.notifications',
        'uses' => 'Admin\SettingsController@notifications',
        'middleware' => 'permission:settings.notifications'
    ]);

    Route::post('admin/settings/notifications', [
        'as' => 'admin.settings.notifications.update',
        'uses' => 'Admin\SettingsController@update',
        'middleware' => 'permission:settings.notifications'
    ]);
});


