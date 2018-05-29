<?php

/**
 * routes
 */
/* * **************   Model binding into route ************************* */

Route::model('user', 'App\User');
Route::model('language', 'App\Language');
Route::model('aggregation', 'App\Aggregation');

Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[0-9a-z-_]+');

/* * *************    Site routes  ********************************* */

Route::get('/', 'PagesController@about');
Route::get('home', 'PagesController@about');
Route::get('about', 'PagesController@about');
Route::get('about-gdm', 'PagesController@about_gdm');

/* DISPATCHER FOR LOCAL AND KEYCLOAK LOGIN */
Route::get('sign-in', function () {

  Log::debug('DB Host: ' .   env('DB_HOST'));
  Log::debug('DB: ' .   env('DB_DATABASE'));
  Log::debug('keycloak server: ' .   config('app')['kc_server']);
  Log::debug('keycloak realm: '  .   config('app')['kc_realm']);
  Log::debug('keycloak redirect-uri: ' .   config('eloquent-oauth')['custom-providers']['keycloak']['redirect_uri'] );

  return view('auth.sign-in');
});


Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/* * *************  Keycloak  ********************************* */

Route::get('keycloak/authenticate', function () {
  return SocialAuth::authorize('keycloak');
});

//OAuth redirects here after authorization
Route::get('keycloak/callback', function () {

    // Automatically log in existing users
    // or create a new user if necessary.
    SocialAuth::login('keycloak', function ($user, $details) {
        //populate the user class.
        //this will be saved automatically by eloquent-oauth.
        Log::debug('details: ' .   print_r($details, true));

        //$user->name = $details->full_name;
        $user->name = $details->nickname;

        $user->username = $details->nickname;
        $user->email = $details->email;
        $user->language = "en";
        //$user->save();
    });
    return Redirect::intended();
});

Route::get('keycloak/logout', function () {

    Auth::logout();

    $logout_url = env('KEYCLOAK_SERVER') . "/auth/realms/" . env('KEYCLOAK_REALM') . "/protocol/openid-connect/logout?redirect_uri=" . env('GDM_PROTOCOL') . "://" . env('GDM_URL');
    return redirect($logout_url)->withCookie(Cookie::forget('XSRF-TOKEN'))->withCookie(Cookie::forget('KEYCLOAK_SESSION'));
});

Route::get('keycloak/profile', function () {
    //echo "<pre>" . print_r(Auth::user(), true);
    $me = Auth::user();
    $user = $me["attributes"];
    return view('user.view', compact('user'));
});



/* * *************    API documentation route  ********************************* */

Route::get('api/' . env('GDM_NAME') . '/' . env('GDM_DATAMODEL_VERSION'), 'ApiDocController@apiGetDoc');
Route::get('api/' . env('GDM_NAME'), 'ApiDocController@apiGetDoc');
Route::get('api/', 'ApiDocController@apiGetDoc');


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


/* * ************  dynamically generated routes for the given data models ************* */
include('routes_datamodel.php');
include('routes_datamodel.php');

include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');

include('routes_datamodel.php');
include('routes_datamodel.php');

include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');

include('routes_datamodel.php');
include('routes_datamodel.php');

include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
include('routes_datamodel.php');
