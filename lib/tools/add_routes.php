<?php

/*
  Route::get('dummies', 'DummiesController@index');
  Route::get('dummy/{slug}', 'DummiesController@show');
  Route::get('dummy/data', 'ProposalsController@data');

 */

$name = $argv[1];

$content = <<<'PHPCODE'

Route::get('NAMEs', 'CNAMEsController@index');
Route::get('NAME/{slug}', 'CNAMEsController@show');
Route::get('NAME/data', 'CNAMEsController@data');

PHPCODE;

$content = str_replace('CNAME', ucfirst($name), $content);
$content = str_replace('NAME', $name, $content);

file_put_contents("../../app/Http/more_routes.php", $content, FILE_APPEND | LOCK_EX);
