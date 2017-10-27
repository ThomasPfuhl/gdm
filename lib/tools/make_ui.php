<?php
/** 
 * @todo integrate database views, additionally to the tables
 * */


require("helpers.php");


echo "\n------------------------\nENVIRONMENT VARIABLES:\n";

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
        list($key, $value) = explode("=", $elt);
        define("$key", $value);
        if ($key != 'DB_PASSWORD') {
            echo " " . $elt . ", ";
        }
        else {
            echo " " . $key . "=XXX";
        }
    }
}

// install modified Model Generator
copy("MakeModelsCommand.php", getcwd() . "/../../vendor/ignasbernotas/laravel-model-generator/src/Commands/MakeModelsCommand.php");
copy("model.stub", getcwd() . "/../../vendor/ignasbernotas/laravel-model-generator/src/stubs/model.stub");


echo "\n\n-----------\nCREATING MODELS...\n\n";

system('cd ../../; php artisan make:models --force=FORCE --ignoresystem --ignore=DATABASECHANGELOG,DATABASECHANGELOGLOCK,migrations,languages --getset');

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
            ORDER BY TABLE_NAME ASC
                ";
$pdo = new PDO(DB_CONNECTION . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$response = $pdo->query($sql);

echo "\n------------\nCREATING CONTROLLERS, VIEWS, FORMS, MENU ITEMS, and ROUTES...\n";

foreach ($response as $row) {
    $name = $row["TABLE_NAME"];
    echo "\n----------------\n" . $row["TABLE_NAME"];

    include("add_controller.php");
    include("add_menu_item.php");
    include("add_views.php");
    include("add_routes.php");
    include("add_form.php");
}

echo "\n\n>>>>>>>>>>>>>>>>>>>> ALL DONE.\n";

echo '<div class="alert alert-success">ALL DONE.</div>';
echo "\n\n";


