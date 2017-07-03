<?php

require("helpers.php");

// get env variables defined in .env
//
//define("DB_CONNECTION", $_ENV["DB_CONNECTION"]);
//define("DB_HOST", $_ENV["DB_HOST"]);
//define("DB_DATABASE", $_ENV["DB_DATABASE"]);
//define("DB_USERNMAE", $_ENV["DB_USERNAME"]);
//define("DB_PASSWORD", $_ENV["DB_PASSWORD"]);

$env = file(getcwd() . "/../../.env");

foreach ($env as $line) {
    $elt = trim($line);
    $pos = strpos($elt, "DB_");
    if ($pos !== False && $pos == 0) {
        echo $elt . "\n";
        list($key, $value) = explode("=", $elt);
        define("$key", $value);
    }
}

// use modified Controller Generator
copy("MakeModelsCommand.php", getcwd() . "/../../vendor/ignasbernotas/laravel-model-generator/src/Commands/");
copy("model.stub", getcwd() . "/../../vendor/ignasbernotas/laravel-model-generator/src/stubs/");

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
                AND TABLE_SCHEMA = '" . DB_DATABASE . "'
                AND TABLE_NAME != 'DATABASECHANGELOG'
                AND TABLE_NAME != 'DATABASECHANGELOGLOCK'
                AND TABLE_NAME != 'migrations'
                AND TABLE_NAME != 'users'
                AND TABLE_NAME != 'password_resets'
                AND TABLE_NAME != 'languages'
                ";
$pdo = new PDO(DB_CONNECTION . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$response = $pdo->query($sql);

echo "\n------------\nCREATING CONTROLLERS, VIEWS, MENU ITEMS, and ROUTES...\n";

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

