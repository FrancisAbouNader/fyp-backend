<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CompanyInterface;
use App\Models\Company;
use App\Validations\CompanyValidation;

class CompanyController extends Controller
{
    // == DECLARATION

    private $validateRequests, $CompanyInterface;
    public function __construct(CompanyValidation $validateRequests, CompanyInterface $CompanyInterface) {

        $this->middleware('auth:api', ['except' => []]);

        $this->validateRequests = $validateRequests;
        $this->CompanyInterface = $CompanyInterface;
    }
//

// == GET


    // ----- get companies
    /**
     * @OA\Get(
     *      path="/Company/GetCompanies",
     *      tags={"Companies"},
     *      summary="get all Companies",
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
     *
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    function getCompanies(Request $request)
    {
        try {

            $company = $this->CompanyInterface->getCompanies($request);
            
            return $this->handleReturn(true, $company, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

//

// == EDIT

    // ----- insert company
    /**
     * @OA\Post(
     * path="/Company/AddCompany",
     * tags={"Companies"},
     * security={{"bearerToken":{}}},
     * summary="Create a new Customers",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to create a new Customers",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="name",description="name"),
     *               @OA\Property(property="location",description="location"),
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
    function insertCompany(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateInsertCompany();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $company = $this->CompanyInterface->insertCompany($request);
            DB::commit();

            return $this->handleReturn(true, $company, "Created successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- update company
    /**
     * @OA\Post(
     * path="/Company/UpdateCompany",
     * tags={"Companies"},
     * security={{"bearerToken":{}}},
     * summary="Update Company",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to update a company",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="id", type="integer"),
     *               @OA\Property(property="name"),
     *               @OA\Property(property="location"),
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

    function updateCompany(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateUpdateCompany();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $company = $this->CompanyInterface->updateCompany($request);
            DB::commit();

            return $this->handleReturn(true, $company, "Updated successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//

// == DELETE

    // ----- delete company
    /**
     * @OA\Delete(
     * path="/Company/DeleteCompany",
     * tags={"Companies"},
     * security={{"bearerToken":{}}},
     * summary="Delete Customers",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to delete company",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="id", type="integer"),
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

    function deleteCompany(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateDeleteCompany();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $company = $this->CompanyInterface->deleteCompany($request);
            DB::commit();

            return $this->handleReturn(true, $company, "Deleted successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//
}
