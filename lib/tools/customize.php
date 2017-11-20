<?php

/**
 * customizing GDM   about, css, js, logos 
 * @todo find a simpler way , merge with about.blade.php
 */
include("helpers.php");

echo getcwd() . "\n";
echo pathinfo(__FILE__)['dirname'] . "/../../.env";


$env = readEnvFile( pathinfo(__FILE__)['dirname'] . "/../../.env" );

$about = file_get_contents("custom/about.html");
$about = preg_replace('/<!--(.*?)-->/Us', '', $about);
$about = str_replace('GDM_NAME', $env['GDM_NAME'], $about);
$about = str_replace('GDM_MANAGER_NAME', $env['GDM_MANAGER_NAME'], $about);
$about = str_replace('GDM_MANAGER_EMAIL', $env['GDM_MANAGER_EMAIL'], $about);


mkdir(getcwd() . "/public/appfiles/");
file_put_contents(getcwd() . "/public/appfiles/about.html", $about);

copy("custom/institution_logo.png", getcwd() . "/public/img/institution_logo.png");
copy("custom/app_logo.png", getcwd() . "/public/img/app_logo.png");

copy("custom/custom.css", getcwd() . "/public/css/custom.css");
copy("custom/custom.js", getcwd() . "/public/js/custom.js");

echo $env['GDM_NAME'] . ": customizing done. \n";
