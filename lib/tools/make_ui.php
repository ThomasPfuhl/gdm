<?php

require("helpers.php");

define("DB_ENGINE", "mysql");
define("DB_HOST", "127.0.0.1");
define("DB_SCHEMA", "projektmetadaten");
define("DB_USER", "root");
define("DB_PASSWORD", "p");

//$stream = fopen('php://output', 'w');
//$stream = fopen('log.txt', 'w');
//Artisan::call(
//        'artisan make:models --force=FORCE --ignoresystem --ignore=DATABASECHANGELOG,DATABASECHANGELOGLOCK,migrations --getset', array()
//);
echo "\n------------\nCREATING MODELS...\n\n";
system('cd ../../; php artisan make:models --force=FORCE --ignoresystem --ignore=DATABASECHANGELOG,DATABASECHANGELOGLOCK,migrations --getset');


$sql = "SELECT TABLE_NAME
            FROM
                INFORMATION_SCHEMA.tables
            WHERE
                TABLE_TYPE='BASE TABLE'
                AND TABLE_SCHEMA = '" . DB_SCHEMA . "'
                AND TABLE_NAME != 'DATABASECHANGELOG'
                AND TABLE_NAME != 'DATABASECHANGELOGLOCK'
                AND TABLE_NAME != 'migrations'
                AND TABLE_NAME != 'users'
                AND TABLE_NAME != 'password_resets'
                AND TABLE_NAME != 'languages'
                ";
$pdo = new PDO(DB_ENGINE . ":host=" . DB_HOST . ";dbname=" . DB_SCHEMA, DB_USER, DB_PASSWORD);
$response = $pdo->query($sql);

echo "\n------------\nCREATING CONNTROLLERS, VIEWS, MENU ITEMS, and ROUTES...\n";

//$result = array();
foreach ($response as $row) {
    $name = $row["TABLE_NAME"];
    //$result[] = $name;
    echo "\n----------------\n" . $row["TABLE_NAME"];

    include("add_controller.php");
    include("add_menu_item.php");
    include("add_views.php");
    include("add_routes.php");
}
//sort($result);
//echo print_r($result, true);

echo "\n\n ALL DONE.\n";

