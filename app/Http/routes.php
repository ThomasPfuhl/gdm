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

Route::get('about', 'PagesController@about');
Route::get('home',  'PagesController@about');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/* * *************    API documentation route  ********************************* */

Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_DATAMODEL_VERSION') , 'AdminController@apiGetDoc');

    
/* * *************    Admin routes  ********************************* */

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    # Admin Dashboard
    Route::get('dashboard', 'Admin\DashboardController@index');

    # Admin UpdateUI
    Route::get('update-ui', 'Admin\UpdateUIController@index');
    Route::get('update-ui/go', 'Admin\UpdateUIController@go');

    # Admin Languages
    Route::get('languages/data', 'Admin\LanguageController@data');
    Route::get('languages/{id}/delete', 'Admin\LanguageController@destroy');
    Route::resource('languages', 'Admin\LanguageController');

    # Admin Users
    Route::get('users/data', 'Admin\UserController@data');
    Route::get('users/{id}/delete', 'Admin\UserController@destroy');
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


/* * ************  dynamically generated routes for the given data model ************* */
include('routes_datamodel.php');
