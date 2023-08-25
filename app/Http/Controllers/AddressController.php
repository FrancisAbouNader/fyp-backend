<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AddressInterface;
use App\Models\Company;
use App\Validations\AddressValidation;

class AddressController extends Controller
{
// == DECLARATION

    private $validateRequests, $AddressInterface;
    public function __construct(AddressValidation $validateRequests, AddressInterface $AddressInterface) {

        $this->middleware('auth:api', ['except' => []]);

        $this->validateRequests = $validateRequests;
        $this->AddressInterface = $AddressInterface;
    }
//

// == GET


    // ----- get Address
    /**
     * @OA\Get(
     *      path="/Address/GetAddresses",
     *      tags={"Address"},
     *      summary="get all addresses",
     *      security={{"bearerToken":{}}},
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
    function getaddresses(Request $request)
    {
        try {
            $addresses = $this->AddressInterface->getAddresses($request);
            
            return $this->handleReturn(true, $addresses, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

    // ----- get User Addresses
    /**
     * @OA\Get(
     *      path="/Address/GetUserAddresses",
     *      tags={"Address"},
     *      summary="get all addresses",
     *      security={{"bearerToken":{}}},
     * 
     *      @OA\Parameter(
     *         name="Id",
     *         in="query",
     *         description="id",
     *         required=true,
     *      ),
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
    function getUserAddresses(Request $request)
    {
        try {
            $validation = $this->validateRequests->idValidation();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            
            $addresses = $this->AddressInterface->getUserAddresses($request);
            
            return $this->handleReturn(true, $addresses, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

    // ----- get address by id
    /**
     * @OA\Get(
     *      path="/Address/GetAddressById",
     *      tags={"Address"},
     *      summary="get address",
     *      security={{"bearerToken":{}}},
     *
     *      @OA\Parameter(
     *         name="Id",
     *         in="query",
     *         description="id",
     *         required=true,
     *      ),
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
    function getAddressById(Request $request)
    {
        try {

            $validation = $this->validateRequests->idValidation();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            $Address = $this->AddressInterface->getAddressById($request->Id);
            
            return $this->handleReturn(true, $Address, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

//

// == EDIT

    // ----- insert Address
    /**
     * @OA\Post(
     * path="/Address/InsertAddress",
     * tags={"Address"},
     * security={{"bearerToken":{}}},
     * summary="Create a new Address",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to create a new brand",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="address_line",description="address_line"),
     *               @OA\Property(property="second_address_line",description="second_address_line"),
     *               @OA\Property(property="city",description="city"),
     *               @OA\Property(property="country",description="country"),
     *               @OA\Property(property="user_id",description="user_id"),
     *               @OA\Property(property="company_id",description="company_id"),
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
    function insertAddress(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateInsertAddress();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            if(isset($request->user_id))
            {
                $request->model_id = $request->user_id;
                $request->model_type = User::class;
            }
            else {
                $request->model_id = $request->company_id;
                $request->model_type = Company::class;
            }

            $Address = $this->AddressInterface->insertAddress($request);
            DB::commit();

            return $this->handleReturn(true, $Address, "Created successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- update Address
    /**
     * @OA\Post(
     * path="/Address/UpdateAddress",
     * tags={"Address"},
     * security={{"bearerToken":{}}},
     * summary="Update Address",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to update a Address",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="id", type="integer"),
     *               @OA\Property(property="address_line",description="address_line"),
     *               @OA\Property(property="second_address_line",description="second_address_line"),
     *               @OA\Property(property="city",description="city"),
     *               @OA\Property(property="country",description="country"),
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

    function updateAddress(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateUpdateAddress();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $Address = $this->AddressInterface->updateAddress($request);
            DB::commit();

            return $this->handleReturn(true, $Address, "Updated successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//

// == DELETE

    // ----- delete Address
    /**
     * @OA\Delete(
     * path="/Address/DeleteAddress",
     * tags={"Address"},
     * security={{"bearerToken":{}}},
     * summary="Delete Address",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to delete Address",
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

    function deleteAddress(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateDeleteAddress();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $Address = $this->AddressInterface->deleteAddress($request);
            DB::commit();

            return $this->handleReturn(true, $Address, "Deleted successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//
}
