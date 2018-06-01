<?php

/** Creation Tool for GUI
 *
 * @author Thomas Pfuhl <thomas.pfuhl@mfn.berlin>
 * */

require("helpers.php");

$verbose = 1;

$cwd = pathinfo(__FILE__)['dirname'];

echo "\n------------------------\nENVIRONMENT VARIABLES:\n";
// get env variables defined in .env
//
$env = file($cwd . "/../../.env");
foreach ($env as $line) {
    $elt = trim($line);
    $pos = strpos($elt, "=");
    $comment = !empty($elt) && $elt[0]=="#";
    if ($pos !== False && !$comment) {
        list($key, $value) = explode("=", $elt);
        define("$key", $value);
        if ($key != 'DB_PASSWORD') {
            echo " " . $elt . "\n";
        } else {
            echo " " . $key . "=XXX\n";
        }
    }
}


echo "\n-----------\nCUSTOM LAYOUT...\n";

copy("../../custom/about.html", "../../resources/views/pages/userinfo.blade.php");
copy("../../custom/404.php", "../../resources/views/errors/404.blade.php");

copy("../../custom/institution_logo.png", "../../public/img/institution_logo.png");
copy("../../custom/app_logo.png", "../../public/img/app_logo.png");

copy("../../custom/custom.css", "../../public/css/custom.css");
copy("../../custom/custom.js", "../../public/js/custom.js");

echo "\n installed.\n";


/////////////////////////////////////////
// install modified Model Generator

copy("MakeModelsCommand.php", $cwd . "/../../vendor/ignasbernotas/laravel-model-generator/src/Commands/MakeModelsCommand.php");
copy("model.stub", $cwd . "/../../vendor/ignasbernotas/laravel-model-generator/src/stubs/model.stub");

$system_excluded_tables = "'" . str_replace( "," , "','", SYSTEM_EXCLUDED_TABLES) . "'";
$gdm_excluded_tables = "'" . str_replace( "," , "','", GDM_EXCLUDED_TABLES) . "'";
echo "\n--------------\nSYSTEM EXCLUDED TABLES: \n" . SYSTEM_EXCLUDED_TABLES . "\n";
echo "\n--------------\nGDM HIDDEN TABLES: \n" . $gdm_excluded_tables . "\n";


echo "\n\n-----------\nCREATING MODELS...\n\n";

$foreign_keys = getAllForeignKeys();
//echo "\n--------------------\n ALL FOREIGN KEYS: " .  implode(",", array_keys($foreign_keys)) . "\n";
//echo "\n--------------------\n ALL FOREIGN KEYS: " .  print_r($foreign_keys,true) . "\n";


//system('cd ../../; php artisan make:models --force=FORCE --ignoresystem --ignore=DATABASECHANGELOG,DATABASECHANGELOGLOCK,migrations,users,languages,gdm_aggregations,oauth_identities --getset');
system("cd ../../; php artisan make:models --force=FORCE --ignoresystem --ignore=" . SYSTEM_EXCLUDED_TABLES . " --getset");




echo "\n------------\nROUTING ENTRYPOINT...\n";

$maintable = toCamelCase(GDM_MAIN_TABLE, true);
$entrypoint = "<?php \n\n/** routes for the given data model \n * all routes are forbidden unless authenticated.\n */\n";
file_put_contents("../../app/Http/routes_datamodel.php", $entrypoint, FILE_TEXT | LOCK_EX);
echo " data model routes created.\n";
file_put_contents("../../app/Http/routes.php", "\ninclude('routes_datamodel.php');", FILE_APPEND | LOCK_EX);

$gdm_agg = <<<'PHPCODE'

Route::get('gdm_aggregations/data',         ['middleware' => 'auth', 'uses' => 'AggregationsController@data']);
Route::get('gdm_aggregations/{id}/datum',   ['middleware' => 'auth', 'uses' => 'AggregationsController@datum']);
Route::get('gdm_aggregations/{id}/edit',    ['middleware' => 'auth', 'uses' => 'AggregationsController@edit']);
Route::get('gdm_aggregations/{id}/delete',  ['middleware' => 'auth', 'uses' => 'AggregationsController@destroy']);
Route::put('gdm_aggregations/{id}',         ['middleware' => 'auth', 'uses' => 'AggregationsController@update']);
//Route::get('gdm_aggregations/create',     ['middleware' => 'auth', 'uses' => 'AggregationsController@create']);
Route::post('gdm_aggregations',             ['middleware' => 'auth', 'uses' => 'AggregationsController@store']);

Route::resource('gdm_aggregations', 'AggregationsController');

PHPCODE;
file_put_contents("../../app/Http/routes_datamodel.php", $gdm_agg, FILE_APPEND | LOCK_EX);


echo " data model routes integrated.\n";


echo "\n------------\nMAIN CONTROLLER...\n";

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
echo " added.\n";

//////////////////////////////
// Keycloak Provider
echo "\n------------\nCREATING KEYCLOAK PROVODER ... ";

$stub = <<<'PHPCODE'
<?php
namespace App\Providers\OAuth2;

use SocialNorm\Exceptions\InvalidAuthorizationCodeException;
use SocialNorm\Providers\OAuth2Provider;

class KeycloakProvider extends OAuth2Provider
{
    protected $authorizeUrl   = "KEYCLOAK_SERVER/auth/realms/KEYCLOAK_REALM/protocol/openid-connect/auth";
    protected $accessTokenUrl = "KEYCLOAK_SERVER/auth/realms/KEYCLOAK_REALM/protocol/openid-connect/token";
    protected $userDataUrl    = "KEYCLOAK_SERVER/auth/realms/KEYCLOAK_REALM/protocol/openid-connect/userinfo";

    protected $scope = [
        'view-profile',
        'manage-account',
    ];

    protected $headers = [
        'authorize' => [],
        'access_token' => [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ],
        'user_details' => [],
    ];

    protected function compileScopes()
    {
        return implode(' ', $this->scope);
    }

    protected function getAuthorizeUrl()
    {
        return $this->authorizeUrl;
    }

    protected function getAccessTokenBaseUrl()
    {
        return $this->accessTokenUrl;
    }

    protected function getUserDataUrl()
    {
        return $this->userDataUrl;
    }

    protected function parseTokenResponse($response)
    {
        return $this->parseJsonTokenResponse($response);
    }

    protected function requestUserData()
    {
        $url = $this->buildUserDataUrl();
        $response = $this->httpClient->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        ]);
        return $this->parseUserDataResponse((string)$response->getBody());
    }

    protected function parseUserDataResponse($response)
    {
        return json_decode($response, true);
    }

    protected function userId()
    {
        return $this->getProviderUserData('sub');
    }

    protected function nickname()
    {
        return $this->getProviderUserData('preferred_username');
    }

    protected function fullName()
    {
        return $this->getProviderUserData('given_name') . ' ' . $this->getProviderUserData('family_name');
    }

    protected function avatar()
    {
        return "";
    }

    protected function email()
    {
        return $this->getProviderUserData('email');
    }
}
PHPCODE;

$content = $stub;
$content = str_replace('KEYCLOAK_SERVER', KEYCLOAK_SERVER, $content);
$content = str_replace('KEYCLOAK_REALM',  KEYCLOAK_REALM,  $content);

file_put_contents("../../app/Providers/OAuth2/KeycloakProvider.php", $content);
echo "\n done.";
///////////////////////////////////



echo "\n\n------------\nCREATING CONTROLLERS, VIEWS, FORMS, MENU ITEMS, and ROUTES...\n";

touch("../../resources/views/partials/menu-items.blade.php");

// all but system excluded tables
$sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.tables
                            WHERE
                                (TABLE_TYPE='BASE TABLE' OR TABLE_TYPE='VIEW')
                                AND TABLE_SCHEMA = '" . DB_DATABASE . "'
                                AND TABLE_NAME NOT IN (" . $system_excluded_tables . ")
                            ORDER BY TABLE_NAME ASC
                                ";
$pdo = new PDO(DB_CONNECTION . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$response = $pdo->query($sql);

foreach ($response as $row) {
    $table_name = $row["TABLE_NAME"];
    $name = toCamelCase($row["TABLE_NAME"]);

    echo "\n----------------\n" . $name  . ": " ;

    include("add_controller.php");
    //include("add_menu_item.php");
    //include("add_views.php");
    include("add_routes.php");
    include("add_form.php");
}

// all but hidden gdm tables
$sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.tables
                            WHERE
                                (TABLE_TYPE='BASE TABLE' OR TABLE_TYPE='VIEW')
                                AND TABLE_SCHEMA = '" . DB_DATABASE . "'
                                AND TABLE_NAME NOT IN (" . $system_excluded_tables .",". $gdm_excluded_tables . ")
                            ORDER BY TABLE_NAME ASC
                                ";
$pdo = new PDO(DB_CONNECTION . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$response = $pdo->query($sql);
foreach ($response as $row) {
    $table_name = $row["TABLE_NAME"];
    $name = toCamelCase($row["TABLE_NAME"]);

    echo "\n----------------\n" . $name  . ": " ;

    include("add_menu_item.php");
    include("add_views.php");
}

// hidden gdm tables
// fake view
$sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.tables
                            WHERE
                                (TABLE_TYPE='BASE TABLE' OR TABLE_TYPE='VIEW')
                                AND TABLE_SCHEMA = '" . DB_DATABASE . "'
                                AND TABLE_NAME IN (" . $gdm_excluded_tables . ")
                            ORDER BY TABLE_NAME ASC
                                ";
$pdo = new PDO(DB_CONNECTION . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$response = $pdo->query($sql);
foreach ($response as $row) {
    $table_name = $row["TABLE_NAME"];
    $name = toCamelCase($row["TABLE_NAME"]);

    echo "\n----------------\n" . $name  . ": " ;

    include("add_views_fake.php");
}
echo "\n\n>>>>>>>>>>>>>>>>>>>> ALL DONE.\n";
