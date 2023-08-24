<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ProductTypeInterface;
use App\Validations\ProductTypeValidation;


class ProductTypeController extends Controller
{
    // == DECLARATION

    private $validateRequests, $ProductTypeInterface;
    public function __construct(ProductTypeValidation $validateRequests, ProductTypeInterface $ProductTypeInterface) {

        $this->middleware('auth:api', ['except' => []]);

        $this->validateRequests = $validateRequests;
        $this->ProductTypeInterface = $ProductTypeInterface;
    }
//

// == GET


    // ----- get product type
    /**
     * @OA\Get(
     *      path="/Admin/GetProductTypes",
     *      tags={"Admin"},
     *      summary="get all product types",
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
    function getProductType(Request $request)
    {
        try {

            $productTypes = $this->ProductTypeInterface->getProductType($request);
            
            return $this->handleReturn(true, $productTypes, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

//

// == EDIT

    // ----- insert product type
    /**
     * @OA\Post(
     * path="/Admin/InsertProductType",
     * tags={"Admin"},
     * security={{"bearerToken":{}}},
     * summary="Create a new product types",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to create a new brand",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="name",description="name"),
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
    function insertProductType(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateInsertProductType();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $productTypes = $this->ProductTypeInterface->insertProductType($request);
            DB::commit();

            return $this->handleReturn(true, $productTypes, "Created successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- update product type
    /**
     * @OA\Post(
     * path="/Admin/UpdateProductType",
     * tags={"Admin"},
     * security={{"bearerToken":{}}},
     * summary="Update prouct tyep",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to update a product",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="id", type="integer"),
     *               @OA\Property(property="name"),
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

    function updateProductType(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateUpdateProductType();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $productTypes = $this->ProductTypeInterface->updateProductType($request);
            DB::commit();

            return $this->handleReturn(true, $productTypes, "Updated successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//

// == DELETE

    // ----- delete product type
    /**
     * @OA\Delete(
     * path="/Admin/DeleteProductType",
     * tags={"Admin"},
     * security={{"bearerToken":{}}},
     * summary="Delete productTypes",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to delete productTypes",
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

    function deleteProductType(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateDeleteProductType();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $productTypes = $this->ProductTypeInterface->deleteProductType($request);
            DB::commit();

            return $this->handleReturn(true, $productTypes, "Deleted successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//
}
