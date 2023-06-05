<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Interfaces\RoleInterface;

class RoleController extends Controller
{

// == DECLARATION

    private $roleRepository;
    public function __construct(RoleInterface $roleRepository)
    {
        $this->middleware('auth:api', ['except' => ['indexPortalRoles']]);

        $this->roleRepository = $roleRepository;
    }

//

// == GET

    // ----- get all roles
    /**
     * @OA\Get(
     * 
     * path="/roles",
     * tags={"Roles"},
     * summary="Retrieve roles",
     * 
     * 
     *      @OA\Response(
     *          response="200",
     *          description="Successful Operation",
     *          @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", description="status" ),
     *          @OA\Property(property="data", type="object", description="data" ),
     *          @OA\Property(property="message", type="string", description="message" ),
     *          ),
     *       ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", description="status" ),
     *          @OA\Property(property="data",type="array",  @OA\Items( type="object"  ),description="data" ),
     *          @OA\Property(property="message", type="string", description="message" ),
     *          ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *
     *     )
     */
    function getAllRoles()
    {
        try {

            $roles = $this->roleRepository->getAllRoles();

            return $this->handleResponse($roles);
        } catch (Exception $ex) {
            return $this->reportError($ex, 'getAllRoles', request());
        }
    }
    
//
}
