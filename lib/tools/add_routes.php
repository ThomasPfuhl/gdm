<?php

/** Creation Tool for adding routes
 *
 * @author Thomas Pfuhl <thomas.pfuhl@mfn.berlin>
 * @todo:  install and use  https://github.com/constant-null/backstubber
 *
 * Verb    Path                        Action  Route Name
 *
 * GET     /users                      index   users.index
 * GET     /users/create               create  users.create
 * POST    /users                      store   users.store
 * GET     /users/{user}               show    users.show
 * GET     /users/{user}/edit          edit    users.edit
 * PUT     /users/{user}               update  users.update
 * DELETE  /users/{user}               destroy users.destroy
 */

echo "routes, ";

$content = <<<'PHPCODE'

////////////////////
// CTABLENAME
////////////////////
// API, returns JSON
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_DATAMODEL_VERSION') ,                      'Data\CTABLENAMEController@apiGetDoc');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_DATAMODEL_VERSION') . '/TABLENAME/',       'Data\CTABLENAMEController@apiGetDoc');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_DATAMODEL_VERSION') . '/TABLENAME/all',    'Data\CTABLENAMEController@apiGetAll');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_DATAMODEL_VERSION') . '/TABLENAME/{id}',   'Data\CTABLENAMEController@apiGetOne');
Route::get('api/' . env('GDM_NAME') .'/' . env('GDM_DATAMODEL_VERSION') . '/TABLENAME/search', 'Data\CTABLENAMEController@apiSearch');
// GUI
Route::get(     'TABLENAME/aggregated', ['middleware' => 'auth', 'uses' => 'Data\CTABLENAMEController@index_aggregated']);
Route::get(     'TABLENAME/data',       ['middleware' => 'auth', 'uses' => 'Data\CTABLENAMEController@data']);
Route::get(     'TABLENAME/{id}/datum', ['middleware' => 'auth', 'uses' => 'Data\CTABLENAMEController@datum']);
Route::get(     'TABLENAME/{id}/edit',  ['middleware' => 'auth', 'uses' => 'Data\CTABLENAMEController@edit']);
Route::delete(  'TABLENAME/{id}/delete',['middleware' => 'auth', 'uses' => 'Data\CTABLENAMEController@destroy']);
Route::post(    'TABLENAME',            ['middleware' => 'auth', 'uses' => 'Data\CTABLENAMEController@store']);
// since we are lazy, we use this shortcut:
Route::resource('TABLENAME', 'Data\CTABLENAMEController');

PHPCODE;

$content = str_replace('CTABLENAME', ucfirst($name), $content);
$content = str_replace('TABLENAME', $name, $content);


$current_content = file_get_contents("../../app/Http/routes_datamodel.php");
$pos = strpos($current_content, trim($content));
if ($pos === FALSE) {
    file_put_contents("../../app/Http/routes_datamodel.php", $content, FILE_APPEND | LOCK_EX);
}
