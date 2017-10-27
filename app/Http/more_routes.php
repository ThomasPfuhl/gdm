<?php 

//////////////////////////////
// API, returns JSON
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/aggregations/', 'AggregationsController@apiGetAll');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/aggregations/{id}', 'AggregationsController@apiGetOne');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/aggregations/search', 'AggregationsController@apiSearch');
// GUI
Route::get('aggregations/aggregated', 'AggregationsController@index_aggregated');
Route::get('aggregations/data', 'AggregationsController@data');
Route::get('aggregations/{id}/datum', 'AggregationsController@datum');
Route::resource('aggregations', 'AggregationsController');

//////////////////////////////
// API, returns JSON
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/communities/', 'CommunitiesController@apiGetAll');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/communities/{id}', 'CommunitiesController@apiGetOne');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/communities/search', 'CommunitiesController@apiSearch');
// GUI
Route::get('communities/aggregated', 'CommunitiesController@index_aggregated');
Route::get('communities/data', 'CommunitiesController@data');
Route::get('communities/{id}/datum', 'CommunitiesController@datum');
Route::resource('communities', 'CommunitiesController');

//////////////////////////////
// API, returns JSON
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/deposits/', 'DepositsController@apiGetAll');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/deposits/{id}', 'DepositsController@apiGetOne');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/deposits/search', 'DepositsController@apiSearch');
// GUI
Route::get('deposits/aggregated', 'DepositsController@index_aggregated');
Route::get('deposits/data', 'DepositsController@data');
Route::get('deposits/{id}/datum', 'DepositsController@datum');
Route::resource('deposits', 'DepositsController');

//////////////////////////////
// API, returns JSON
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/products/', 'ProductsController@apiGetAll');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/products/{id}', 'ProductsController@apiGetOne');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/products/search', 'ProductsController@apiSearch');
// GUI
Route::get('products/aggregated', 'ProductsController@index_aggregated');
Route::get('products/data', 'ProductsController@data');
Route::get('products/{id}/datum', 'ProductsController@datum');
Route::resource('products', 'ProductsController');

//////////////////////////////
// API, returns JSON
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/members/', 'MembersController@apiGetAll');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/members/{id}', 'MembersController@apiGetOne');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_VERSION') . '/members/search', 'MembersController@apiSearch');
// GUI
Route::get('members/aggregated', 'MembersController@index_aggregated');
Route::get('members/data', 'MembersController@data');
Route::get('members/{id}/datum', 'MembersController@datum');
Route::resource('members', 'MembersController');
