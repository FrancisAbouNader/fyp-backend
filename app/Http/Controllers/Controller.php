<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Wahrehouse Management - API Documentation",
 *      description="Wahrehouse Management open api documentation",
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Main api documentation"
 * ),
 * 
 * @OA\SecurityScheme(
 *      securityScheme="APIKey",
 *      type="apiKey",
 *      in="header",
 *      name="X-Authorization"
 * )
 * 
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
