<?php

/**
 * @todo integrate database views, additionally to the tables
 * */
require("helpers.php");


echo "\n------------------------\nENVIRONMENT VARIABLES:\n";

// get env variables defined in .env
//

$env = file(getcwd() . "/../../.env");
foreach ($env as $line) {
    $elt = trim($line);
    //$pos = strpos($elt, "DB_");
    //if ($pos !== False && $pos == 0) 
    $pos = strpos($elt, "=");
    if ($pos !== False) 
    {
        list($key, $value) = explode("=", $elt);
        define("$key", $value);
        if ($key != 'DB_PASSWORD') {
            echo " " . $elt . "\n";
        } else {
            echo " " . $key . "=XXX\n";
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


echo "\n------------\nROUTING ENTRYPOINT ---\n";
$maintable = ucfirst(GDM_MAIN_TABLE);
$entrypoint = "<?php \n\n"
        . "// Entry Point\n"
        . "Route::get('/', '${maintable}Controller@index'); \n";
file_put_contents("../../app/Http/more_routes.php", $entrypoint, FILE_TEXT | LOCK_EX);


echo "\n------------\n MAIN CONTROLLER ---\n";

$stub = <<<'PHPCODE'
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
  * @SWG\Swagger(  
  *   schemes={"http","https"},  
  *   host="GDM_URL",  
  *   basePath="/api",  
  *   @SWG\Info(  
  *     version="GDM_DATAMODEL_VERSION",  
  *     title="GDM_NAME",  
  *     description="GDM_TITLE",  
  *     termsOfService="",  
  *     @SWG\Contact(  
  *       email="GDM_MANAGER_EMAIL"  
  *     ),  
  *     @SWG\License(  
  *       name="GNU General Public License",  
  *       url="http://www.gnu.org/licenses/"  
  *     )  
  *   )
  * )  
  */  
abstract class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;
}
PHPCODE;


$content = $stub;
$content = str_replace('GDM_URL', GDM_URL, $content);
$content = str_replace('GDM_NAME', GDM_NAME, $content);
$content = str_replace('GDM_TITLE', GDM_TITLE, $content);
$content = str_replace('GDM_DATAMODEL_VERSION', GDM_DATAMODEL_VERSION, $content);
$content = str_replace('GDM_MANAGER_EMAIL', GDM_MANAGER_EMAIL, $content);

file_put_contents("../../app/Http/Controllers/Controller.php", $content);


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


