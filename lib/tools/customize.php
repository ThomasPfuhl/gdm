<?php

/**
 * customizing GDM
 */
include("helpers.php");

$env = readEnvFile(getcwd() . "/.env");

$about = file_get_contents("custom/about.html");
$about = preg_replace('/<!--(.*?)-->/Us', '', $about);
$about = str_replace('GDM_NAME', $env['GDM_NAME'], $about);
$about = str_replace('GDM_MANAGER_NAME', $env['GDM_MANAGER_NAME'], $about);
$about = str_replace('GDM_MANAGER_EMAIL', $env['GDM_MANAGER_EMAIL'], $about);
file_put_contents(getcwd() . "/public/appfiles/about.html", $about);

copy("custom/institution_logo.png", getcwd() . "/public/img/institution_logo.png");
copy("custom/app_logo.png", getcwd() . "/public/img/app_logo.png");

copy("custom/custom.css", getcwd() . "/public/css/custom.css");
copy("custom/custom.js", getcwd() . "/public/js/custom.js");

echo $env['GDM_NAME'] . ": customizing done. \n";
