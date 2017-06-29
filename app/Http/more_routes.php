<?php

Route::get('agencies', 'AgenciesController@index');
Route::get('agencies/{slug}', 'AgenciesController@show');
Route::get('agencies/data', 'AgenciesController@data');

Route::get('agents', 'AgentsController@index');
Route::get('agents/{slug}', 'AgentsController@show');
Route::get('agents/data', 'AgentsController@data');

Route::get('dummies', 'DummiesController@index');
Route::get('dummies/{slug}', 'DummiesController@show');
Route::get('dummies/data', 'DummiesController@data');

Route::get('foobars', 'FoobarsController@index');
Route::get('foobars/{slug}', 'FoobarsController@show');
Route::get('foobars/data', 'FoobarsController@data');

Route::get('institutions', 'InstitutionsController@index');
Route::get('institutions/{slug}', 'InstitutionsController@show');
Route::get('institutions/data', 'InstitutionsController@data');

Route::get('networkPartners', 'NetworkPartnersController@index');
Route::get('networkPartners/{slug}', 'NetworkPartnersController@show');
Route::get('networkPartners/data', 'NetworkPartnersController@data');

Route::get('networks', 'NetworksController@index');
Route::get('networks/{slug}', 'NetworksController@show');
Route::get('networks/data', 'NetworksController@data');

Route::get('projects', 'ProjectsController@index');
Route::get('projects/{slug}', 'ProjectsController@show');
Route::get('projects/data', 'ProjectsController@data');

Route::get('proposals', 'ProposalsController@index');
Route::get('proposals/{slug}', 'ProposalsController@show');
Route::get('proposals/data', 'ProposalsController@data');
