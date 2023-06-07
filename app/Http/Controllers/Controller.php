<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Warehouse Management - API Documentation",
 *      description="Warehouse Management open api documentation",
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
 *      securityScheme="bearerToken",
 *      type="http",
 *      scheme="bearer"
 * )
 * 
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // ----- function to handle controller function response
    function handleReturn($success, $data, $message){
        return response()->json([
            "success" => $success,
            "data" => $data,
            "message" => $message
        ]);
    }

    // --- catch exceptions
    public function reportError($exception){

        //-- return error
        return $this->handleReturn(false, null, $exception->getmessage()); # __("messages.error_contact_admin")
    }

}
