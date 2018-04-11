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

Route::get('about', 'PagesController@about');
Route::get('about-gdm', 'PagesController@about_gdm');
Route::get('home', 'PagesController@about');

Route::get('gdm_aggregations/data', 'AggregationsController@data');
Route::get('gdm_aggregations/{id}/datum', 'AggregationsController@datum');

Route::get('gdm_aggregations/{id}/edit', ['middleware' => 'auth', 'uses' => 'AggregationsController@edit']);
Route::get('gdm_aggregations/{id}/delete', ['middleware' => 'auth', 'uses' => 'AggregationsController@destroy']);
Route::put('gdm_aggregations/{id}', ['middleware' => 'auth', 'uses' => 'AggregationsController@update']);
//Route::get('gdm_aggregations/create',     ['middleware' => 'auth', 'uses' => 'AggregationsController@create']);
Route::post('gdm_aggregations', ['middleware' => 'auth', 'uses' => 'AggregationsController@store']);

Route::resource('gdm_aggregations', 'AggregationsController');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/* * *************  Keycloak  ********************************* */

Route::get('keycloak/authorize', function () {
    return SocialAuth::authorize('keycloak');
});

//OAuth redirects here after authorization
Route::get('keycloak/callback', function () {
    // Automatically log in existing users
    // or create a new user if necessary.
    SocialAuth::login('keycloak', function ($user, $details) {
        //populate the user class.
        //this will be saved automatically by eloquent-oauth.

        $user->name = $details->full_name;
        $user->name = $details->nickname;

        $user->username = $details->nickname;
        $user->email = $details->email;
        $user->language = "en";
        //$user->save();

        echo "<pre>";
        //echo "user: " . print_r($user, true);
        echo "details: " . print_r($details, true);
        echo "</pre>";
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
//include('routes_datamodel.php');

include('routes_datamodel.php');
