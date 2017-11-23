<?php

/**
 * customizing GDM   about, css, js, logos
 */
include("helpers.php");

$cwd = pathinfo(__FILE__)['dirname'];

$env = readEnvFile($cwd . "/../../.env");

$about = file_get_contents( $cwd . "/../../custom/about.html" );
$about = preg_replace('/<!--(.*?)-->/Us', '', $about);
$about = str_replace('GDM_NAME', $env['GDM_NAME'], $about);
$about = str_replace('GDM_MANAGER_NAME', $env['GDM_MANAGER_NAME'], $about);
$about = str_replace('GDM_MANAGER_EMAIL', $env['GDM_MANAGER_EMAIL'], $about);


file_put_contents($cwd . "/../../public/appfiles/about.html", $about);

copy($cwd . "/../../custom/institution_logo.png", $cwd . "/../../public/img/institution_logo.png");
copy($cwd . "/../../custom/app_logo.png", $cwd . "/../../public/img/app_logo.png");

copy($cwd . "/../../custom/custom.css", $cwd . "/../../public/css/custom.css");
copy($cwd . "/../../custom/custom.js", $cwd . "/../../public/js/custom.js");

echo $env['GDM_NAME'] . ": customizing done. \n";
