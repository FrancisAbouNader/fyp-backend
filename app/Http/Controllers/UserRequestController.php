<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\UserRequestInterface;
use App\Validations\UserRequestValidation;

class UserRequestController extends Controller
{
// == DECLARATION

    private $validateRequests, $userRequestInterface;
    public function __construct(UserRequestValidation $validateRequests, UserRequestInterface $userRequestInterface) {

        $this->middleware('auth:api', ['except' => ['']]);

        $this->validateRequests = $validateRequests;
        $this->userRequestInterface = $userRequestInterface;
    }
//

// == GET

    // ----- get customer requests 
    /**
     * @OA\Get(
     *      path="/Admin/GetPendingCustomerRequests",
     *      tags={"Requests"},
     *      summary="pending requests",
     *      security={{"bearerToken":{}}},
     *
     *     @OA\Parameter(
     *        name="RequestStatusId", in="query", required=false, @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response="200",
     *          description="Successful Operation",
     *          @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", description="status" ),
     *          @OA\Property(property="data", type="object", description="data" ),
     *          @OA\Property(property="message", type="string", description="message" ),
     *          ),
     *        ),
     * )
     */
    function getPendingCustomerRequests(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateGetCustomerRequests();
            if ($validation->fails()) 
                return $this->handleReturn(false, null, $validation->errors()->first());
            
            $customer_requests = $this->userRequestInterface->getPendingCustomerRequests($request);

            return $this->handleReturn(true, $customer_requests,null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }
//

// == EDIT

    // ----- insert user request
    /**
     * @OA\Post(
     * path="/Admin/InsertUserRequest",
     * tags={"Requests"},
     * security={{"bearerToken":{}}},
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed login to the portals",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="user_id",description="email"),
     *               @OA\Property(property="company_id",description="password"),
     *               @OA\Property(property="products",type="array", @OA\Items(
     *               @OA\Property(property="product_id",description="product_id", type="integer"),
     *               @OA\Property(property="quantity",description="quantity", type="integer"),
     *                  ),),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response="200",
     *          description="Successful Operation",
     *          @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", description="status" ),
     *          @OA\Property(property="data", type="object", description="data" ),
     *          @OA\Property(property="message", type="string", description="message" ),
     *          ),
     *        ),
     *       @OA\Response(
     *          response="422",
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", description="status" ),
     *          @OA\Property(property="data",type="array",  @OA\Items( type="object"  ),description="data" ),
     *          @OA\Property(property="message", type="string", description="message" ),
     *          ),
     *       ),
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
     * )
     */
    function insertUserRequest(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateinsertUserRequest();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $user_request = $this->userRequestInterface->insertUserRequest($request);
            DB::commit();

            return $this->handleReturn(true, $user_request, "Created successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- change request status
    /**
     * @OA\Post(
     * path="/Admin/ChangeRequestStatus",
     * tags={"Requests"},
     * security={{"bearerToken":{}}},
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed login to the portals",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="user_request_id"),
     *               @OA\Property(property="items",type="array", @OA\Items(
     *               @OA\Property(property="product_id", type="integer"),
     *               @OA\Property(property="item_id", type="integer"),
     *                  ),),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response="200",
     *          description="Successful Operation",
     *          @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", description="status" ),
     *          @OA\Property(property="data", type="object", description="data" ),
     *          @OA\Property(property="message", type="string", description="message" ),
     *          ),
     *        ),
     *       @OA\Response(
     *          response="422",
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", description="status" ),
     *          @OA\Property(property="data",type="array",  @OA\Items( type="object"  ),description="data" ),
     *          @OA\Property(property="message", type="string", description="message" ),
     *          ),
     *       ),
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
     * )
     */
    function changeRequestStatus(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateChangeRequest();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $user_request = $this->userRequestInterface->changeRequestStatus($request);
            DB::commit();

            // return $this->handleReturn(true, $token, "Logged in successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }
//
}
