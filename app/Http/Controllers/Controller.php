<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
  * @SWG\Swagger(
  *   schemes={"http","https"},
  *   host="localhost:8000",
  *   basePath="/api",
  *   @SWG\Info(
  *     version="v0_9",
  *     title="kitty",
  *     description="money pool for coffee and tea",
  *     @SWG\Contact(
  *       email="thomas.pfuhl@mfn-berlin.de"
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