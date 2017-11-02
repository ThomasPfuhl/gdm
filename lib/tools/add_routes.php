<?php

/** Creation Tool for adding routes
 *
 * @author Thomas Pfuhl <thomas.pfuhl@mfn-berlin.de>
 * @todo:  install and use  https://github.com/constant-null/backstubber
 * 
 * Verb    Path                        Action  Route Name
 * GET     /users                      index   users.index
 * GET     /users/create               create  users.create
 * POST    /users                      store   users.store
 * GET     /users/{user}               show    users.show
 * GET     /users/{user}/edit          edit    users.edit
 * PUT     /users/{user}               update  users.update
 * DELETE  /users/{user}               destroy users.destroy
 */

echo "\n adding routes for " . $name;

$content = <<<'PHPCODE'

//////////////////////////////
// API, returns JSON
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_DATAMODEL_VERSION') . '/TABLENAME/', 'CTABLENAMEController@apiGetDoc');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_DATAMODEL_VERSION') . '/TABLENAME/all', 'CTABLENAMEController@apiGetAll');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_DATAMODEL_VERSION') . '/TABLENAME/{id}', 'CTABLENAMEController@apiGetOne');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_DATAMODEL_VERSION') . '/TABLENAME/search', 'CTABLENAMEController@apiSearch');
// GUI
Route::get('TABLENAME/aggregated',  'CTABLENAMEController@index_aggregated');
Route::get('TABLENAME/data',        'CTABLENAMEController@data');
Route::get('TABLENAME/{id}/datum',  'CTABLENAMEController@datum');
// FORBIDDEN, unless authenticated:
Route::get(     'TABLENAME/{id}/edit',  ['middleware' => 'auth', 'uses' => 'CTABLENAMEController@show']);
Route::put(     'TABLENAME/{id}',       ['middleware' => 'auth', 'uses' => 'CTABLENAMEController@show']);
Route::delete(  'TABLENAME/{id}',       ['middleware' => 'auth', 'uses' => 'CTABLENAMEController@show']);
// since we are lazy, we use this shortcut:
Route::resource('TABLENAME', 'CTABLENAMEController');
// FORBIDDEN, unless authenticated:
Route::get(     'TABLENAME/create',     ['middleware' => 'auth', 'uses' => 'CTABLENAMEController@show']);
Route::post(    'TABLENAME',            ['middleware' => 'auth', 'uses' => 'CTABLENAMEController@show']);

PHPCODE;

$content = str_replace('CTABLENAME', ucfirst($name), $content);
$content = str_replace('TABLENAME', $name, $content);


$current_content = file_get_contents("../../app/Http/more_routes.php");
$pos = strpos($current_content, trim($content));
if ($pos === FALSE) {
    file_put_contents("../../app/Http/more_routes.php", $content, FILE_APPEND | LOCK_EX);
}

