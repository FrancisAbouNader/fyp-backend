<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CompanyRequestInterface;
use App\Validations\CompanyRequestValidation;

class CompanyRequestController extends Controller
{
// == DECLARATION

    private $validateRequests, $companyRequestInterface;
    public function __construct(CompanyRequestValidation $validateRequests, CompanyRequestInterface $companyRequestInterface) {

        $this->middleware('auth:api', ['except' => ['']]);

        $this->validateRequests = $validateRequests;
        $this->companyRequestInterface = $companyRequestInterface;
    }
//

// == GET

    // ----- get company requests 
    /**
     * @OA\Get(
     *      path="/Admin/GetPendingCompanyRequests",
     *      tags={"Requests"},
     *      summary="pending requests",
     *      security={{"bearerToken":{}}},
     * 
     *     @OA\Parameter(
     *        name="companyId", in="query", required=true, @OA\Schema(type="integer")
     *     ),
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
     *        ),
     * )
     */
    function getPendingCompanyRequests(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateGetCompanyRequests();
            if ($validation->fails()) 
                return $this->handleReturn(false, null, $validation->errors()->first());
            
            $customer_requests = $this->companyRequestInterface->getPendingCompanyRequests($request);

            return $this->handleReturn(true, $customer_requests,null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }
//

// == EDIT

    // ----- InsertCompanyRequest
    /**
     * @OA\Post(
     * path="/Admin/InsertCompanyRequest",
     * tags={"Requests"},
     * security={{"bearerToken":{}}},
     * summary="InsertCompanyRequest",
     *     @OA\RequestBody(
     *           required=true,
     *           description="InsertCompanyRequest",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="company_from_id",description="email"),
     *               @OA\Property(property="company_to_id",description="password"),
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
    function insertCompanyRequest(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateinsertCompanyRequest();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $company_request = $this->companyRequestInterface->insertCompanyRequest($request);
            DB::commit();

            return $this->handleReturn(true, $company_request, "Created successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- change request status
    /**
     * @OA\Post(
     * path="/Admin/ChangeCompanRequestStatus",
     * tags={"Requests"},
     * security={{"bearerToken":{}}},
     * summary="Login",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed login to the portals",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="email",description="email"),
     *               @OA\Property(property="password",description="password"),
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
            // $validation =  $this->validateRequests->validateLogin();
            // if ($validation->fails()) {
            //     return $this->handleReturn(false, null, $validation->errors()->first());
            // }

            DB::beginTransaction();

            DB::commit();

            // return $this->handleReturn(true, $token, "Logged in successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }
//
}
