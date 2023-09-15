<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ProductInterface;
use App\Validations\ProductValidation;


class ProductController extends Controller
{
// == DECLARATION

    private $validateRequests, $ProductInterface;
    public function __construct(ProductValidation $validateRequests, ProductInterface $ProductInterface) {

        $this->middleware('auth:api', ['except' => []]);

        $this->validateRequests = $validateRequests;
        $this->ProductInterface = $ProductInterface;
    }
//

// == GET


    // ----- get Product by id
    /**
     * @OA\Get(
     *      path="/Product/GetProductById",
     *      tags={"Product"},
     *      summary="get Product",
     *      security={{"bearerToken":{}}},
     *
     *      @OA\Parameter(
     *         name="Id",
     *         in="query",
     *         description="id",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="company_id",
     *         in="query",
     *         description="id",
     *         required=false,
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
    function getProductById(Request $request)
    {
        try {
            $validation = $this->validateRequests->idValidation();
            if ($validation->fails())
                return $this->handleReturn(false, null, $validation->errors()->first());
            

            $Product = $this->ProductInterface->getProductById($request);
            
            return $this->handleReturn(true, $Product, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

    // ----- get products
    /**
     * @OA\Get(
     *      path="/Product/GetProducts",
     *      tags={"Product"},
     *      summary="get all products",
     *      security={{"bearerToken":{}}},
     *
     *      @OA\Parameter(
     *         name="company_id",
     *         in="query",
     *         description="id",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="ProductName",
     *         in="query",
     *         description="name",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="BrandId",
     *         in="query",
     *         description="brand id",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="ProductTypeId",
     *         in="query",
     *         description="ProductTypeId",
     *         required=false,
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
    
    function getProducts(Request $request)
    {
        try {
            $validation = $this->validateRequests->getProductsValidation();
            if ($validation->fails())
                return $this->handleReturn(false, null, $validation->errors()->first());

            $products = $this->ProductInterface->getProducts($request);
            
            return $this->handleReturn(true, $products, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

    // ----- get company products sales
    /**
     * @OA\Get(
     *      path="/Product/GetCompanyProductsSales",
     *      tags={"Product"},
     *      summary="get products sales",
     *      security={{"bearerToken":{}}},
     *
     *      @OA\Parameter(
     *         name="company_id",
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
    
     function getCompanyProductsSales(Request $request)
     {
         try {
             $validation = $this->validateRequests->getCompanyProductsSalesValidation();
             if ($validation->fails())
                 return $this->handleReturn(false, null, $validation->errors()->first());
 
             $products = $this->ProductInterface->getCompanyProductsSales($request);
             
             return $this->handleReturn(true, $products, null);
         } catch (Exception $ex) {
             return $this->reportError($ex);
         }
     }

//

// == EDIT

    // ----- insert product
    /**
     * @OA\Post(
     * path="/Product/InsertProduct",
     * tags={"Product"},
     * security={{"bearerToken":{}}},
     * summary="Create a new product",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to create a new brand",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="name",description="productName"),
     *               @OA\Property(property="model_number",description="productName"),
     *               @OA\Property(property="package_height",description="packageHeight"),
     *               @OA\Property(property="package_width",description="packageWidth"),
     *               @OA\Property(property="package_length",description="packageLength"),
     *               @OA\Property(property="package_weight",description="packageWeight"),
     *               @OA\Property(property="product_height",description="productHeight"),
     *               @OA\Property(property="product_width",description="productWidth"),
     *               @OA\Property(property="product_length",description="productLength"),
     *               @OA\Property(property="product_weight",description="productWeight"),
     *               @OA\Property(property="description",description="description"),
     *               @OA\Property(property="brand_id",description="brandId"),
     *               @OA\Property(property="product_type_id",description="productTypeId"),
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
    function insertProduct(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateInsertProduct();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $product = $this->ProductInterface->insertProduct($request);
            DB::commit();

            return $this->handleReturn(true, $product, "Created successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- update product
    /**
     * @OA\Post(
     * path="/Product/UpdateProduct",
     * tags={"Product"},
     * security={{"bearerToken":{}}},
     * summary="Update product",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to update a product",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="id", type="integer"),
     *               @OA\Property(property="name",description="productName"),
     *               @OA\Property(property="model_number",description="productName"),
     *               @OA\Property(property="package_height",description="packageHeight"),
     *               @OA\Property(property="package_width",description="packageWidth"),
     *               @OA\Property(property="package_length",description="packageLength"),
     *               @OA\Property(property="package_weight",description="packageWeight"),
     *               @OA\Property(property="product_height",description="productHeight"),
     *               @OA\Property(property="product_width",description="productWidth"),
     *               @OA\Property(property="product_length",description="productLength"),
     *               @OA\Property(property="product_weight",description="productWeight"),
     *               @OA\Property(property="description",description="description"),
     *               @OA\Property(property="brand_id",description="brandId"),
     *               @OA\Property(property="product_type_id",description="productTypeId"),
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

    function updateProduct(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateUpdateProduct();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $Product = $this->ProductInterface->updateProduct($request);
            DB::commit();

            return $this->handleReturn(true, $Product, "Updated successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//

// == DELETE

    // ----- delete product
    /**
     * @OA\Delete(
     * path="/Product/DeleteProduct",
     * tags={"Product"},
     * security={{"bearerToken":{}}},
     * summary="Delete product",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to delete product",
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

    function deleteProduct(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateDeleteProduct();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $Product = $this->ProductInterface->deleteProduct($request);
            DB::commit();

            return $this->handleReturn(true, $Product, "Deleted successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//
}
