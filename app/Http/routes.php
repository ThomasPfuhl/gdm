<?php

/**
 * routes
 */
/* * **************   Model binding into route ************************* */

Route::model('user', 'App\User');
Route::model('language', 'App\Language');

Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[0-9a-z-_]+');

/* * *************    Site routes  ********************************* */

Route::get('/', 'DepositsController@index');

Route::get('home', 'HomeController@index');
Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');


Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/* * *************    Admin routes  ********************************* */

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    # Admin Dashboard
    Route::get('dashboard', 'Admin\DashboardController@index');

    # Admin UpdateUI
    Route::get('update-ui', 'Admin\UpdateUIController@index');

    # Admin Languages
    Route::get('languages/data', 'Admin\LanguageController@data');
    Route::resource('languages', 'Admin\LanguageController');

    # Admin Users
    Route::get('users/data', 'Admin\UserController@data');
    Route::resource('users', 'Admin\UserController');
});


/* * *************   API Admin routes  ********************************* */
Route::group(['prefix' => 'api/admin', 'middleware' => 'auth'], function() {

    # Languages
    Route::get('languages', 'Admin\LanguageController@apiGetAll');
    Route::get('languages/{id}', 'Admin\LanguageController@apiGetOne');

    # Users
    Route::get('users', 'Admin\UserController@apiGetAll');
    Route::get('users/{id}', 'Admin\UserController@apiGetOne');
});


/* * ************  dynamically generated routes ************* */
include('more_routes.php');
