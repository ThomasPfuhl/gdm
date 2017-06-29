<?php

/**
 * routes
 * @todo write a dummy HomeController
 */
/* * **************   Model binding into route ************************* */
Route::model('project', 'App\Models\Project');

Route::model('user', 'App\User');
Route::model('language', 'App\Language');

Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[0-9a-z-_]+');

/* * *************    Site routes  ********************************* */

Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');

//Route::get('/', 'HomeController@index');
//Route::get('home', 'HomeController@index');

Route::get('/', 'ProjectsController@index');
Route::get('home', 'ProjectsController@index');

Route::get('projects', 'ProjectsController@index');
Route::get('projects/{slug}', 'ProjectsController@show');
Route::get('projects/data', 'ProjectsController@data');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/* * *************    Admin routes  ********************************* */
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    # Admin Dashboard
    Route::get('dashboard', 'Admin\DashboardController@index');


    # Admin update UI
    Route::get('update-ui', 'Admin\UpdateUIController@index');

    # Language
    Route::get('language/data', 'Admin\LanguageController@data');
    Route::get('language/{language}/show', 'Admin\LanguageController@show');
    Route::get('language/{language}/edit', 'Admin\LanguageController@edit');
    Route::get('language/{language}/delete', 'Admin\LanguageController@delete');
    Route::resource('language', 'Admin\LanguageController');

    # Projects
    Route::get('project/data', 'Admin\ProjectController@data');
    Route::get('project/{project}/show', 'Admin\ProjectController@show');

    Route::get('project/{project}/edit', 'Admin\ProjectController@edit');
    Route::post('project/{project}/edit', 'Admin\ProjectController@edit');

    Route::get('project/{project}/delete', 'Admin\ProjectController@delete');
    Route::get('project/reorder', 'Admin\ProjectController@getReorder');
    Route::resource('project', 'Admin\ProjectController');

    # Users
    Route::get('user/data', 'Admin\UserController@data');
    Route::get('user/{user}/show', 'Admin\UserController@show');
    Route::get('user/{user}/edit', 'Admin\UserController@edit');
    Route::get('user/{user}/delete', 'Admin\UserController@delete');
    Route::resource('user', 'Admin\UserController');
    Route::resource('users', 'Admin\UserController');
});

/* * ************  dynamically generated routes ************* */

include('more_routes.php');
