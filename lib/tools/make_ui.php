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
    $pos = strpos($elt, "=");
    if ($pos !== False) {
        list($key, $value) = explode("=", $elt);
        define("$key", $value);
        if ($key != 'DB_PASSWORD') {
            echo " " . $elt . "\n";
        } else {
            echo " " . $key . "=XXX\n";
        }
    }
}


echo "\n------------------------\nCUSTOM LAYOUT:\n";

$about = file_get_contents("custom/about.html");
$content = file_get_contents("../../resources/views/pages/about.blade.php");
$content = str_replace('CUSTOM_ABOUT', $about, $content);
file_put_contents("../../resources/views/pages/about.blade.php", $content, FILE_TEXT | LOCK_EX);

copy("custom/institution_logo.png", "../../public/img/institution_logo.png");
copy("custom/app_logo.png", "../../public/img/app_logo.png");

copy("custom/custom.css", "../../public/css/custom.css");
copy("custom/custom.js", "../../public/js/custom.js");

echo "\n custom layout installed.\n";


/////////////////////////////////////////
// install modified Model Generator

copy("MakeModelsCommand.php", getcwd() . "/../../vendor/ignasbernotas/laravel-model-generator/src/Commands/MakeModelsCommand.php");
copy("model.stub", getcwd() . "/../../vendor/ignasbernotas/laravel-model-generator/src/stubs/model.stub");


echo "\n\n-----------\nCREATING MODELS...\n\n";

mkdir(" ../../app/Models");
system('cd ../../; php artisan make:models --force=FORCE --ignoresystem --ignore=DATABASECHANGELOG,DATABASECHANGELOGLOCK,migrations,users,languages,gdm_aggregations --getset');

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
                AND TABLE_NAME != 'gdm_aggregations'
            ORDER BY TABLE_NAME ASC
                ";
$pdo = new PDO(DB_CONNECTION . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$response = $pdo->query($sql);


echo "\n------------\nROUTING ENTRYPOINT ---\n";

$maintable = toCamelCase(GDM_MAIN_TABLE, true);
$entrypoint = "<?php \n\n"
        . "// Entry Point\n"
        . "Route::get('/', 'Data\\${maintable}Controller@index'); \n";
file_put_contents("../../app/Http/routes_datamodel.php", $entrypoint, FILE_TEXT | LOCK_EX);
echo " data model routes created.\n";
file_put_contents("../../app/Http/routes.php", "include('routes_datamodel.php');", FILE_APPEND | LOCK_EX);
echo " data model routes integrated.\n";


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
$content = str_replace('""', '"', $content);

file_put_contents("../../app/Http/Controllers/Controller.php", $content);


echo "\n------------\nCREATING CONTROLLERS, VIEWS, FORMS, MENU ITEMS, and ROUTES...\n";

touch("../../resources/views/partials/menu-items.blade.php");

foreach ($response as $row) {
    $table_name = $row["TABLE_NAME"];
    $name = toCamelCase($row["TABLE_NAME"]);
//    $lc_name = toCamelCase($row["TABLE_NAME"], false); // currently unused
//    $hyphen_name = toHyphen($row["TABLE_NAME"]); // currently unused

    echo "\n----------------\n" . $name;

    include("add_controller.php");
    include("add_menu_item.php");
    include("add_views.php");
    include("add_routes.php");
    include("add_form.php");
}

echo "\n\n>>>>>>>>>>>>>>>>>>>> ALL DONE.\n";

echo '<div class="alert alert-success">ALL DONE.</div>';
echo "\n\n";


