<?php

/** Creation Tool for adding routes
 *
 * @author Thomas Pfuhl <thomas.pfuhl@mfn-berlin.de>
 * @todo:  install and use  https://github.com/constant-null/backstubber
 */
/*
  Route::get('dummies', 'DummiesController@index');
  Route::get('dummies/{slug}', 'DummiesController@show');
  Route::get('dummies/data', 'DummiesController@data');

 */
echo "\n adding routes for " . $name;


$content = <<<'PHPCODE'

Route::get('NAME', 'CNAMEController@index');
Route::get('NAME/{slug}', 'CNAMEController@show');
Route::get('NAME/data', 'CNAMEController@data');

PHPCODE;

$content = str_replace('CNAME', ucfirst($name), $content);
$content = str_replace('NAME', $name, $content);

$current_content = file_get_contents("../../app/Http/more_routes.php");
$pos = strpos($current_content, trim($content));
if ($pos === FALSE) {
    file_put_contents("../../app/Http/more_routes.php", $content, FILE_APPEND | LOCK_EX);
}

