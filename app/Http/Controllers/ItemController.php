<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Interfaces\ItemInterface;
use Illuminate\Support\Facades\DB;
use App\Validations\ItemValidation;

class ItemController extends Controller
{
// == DECLARATION

    private $validateRequests, $itemInterface;
    public function __construct(ItemValidation $validateRequests, ItemInterface $itemInterface) {

        $this->middleware('auth:api', ['except' => []]);

        $this->validateRequests = $validateRequests;
        $this->itemInterface = $itemInterface;
    }
//

// == GET


    // ----- get Item by id
    /**
     * @OA\Get(
     *      path="/Item/GetItemById",
     *      tags={"Admin"},
     *      summary="get item",
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
    function getItemById(Request $request)
    {
        try {

            $validation = $this->validateRequests->idValidation();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            $Item = $this->itemInterface->getItemById($request->Id);
            
            return $this->handleReturn(true, $Item, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }
    
    // ----- get items
    /**
     * @OA\Get(
     *      path="/Item/GetItems",
     *      tags={"Item"},
     *      security={{"bearerToken":{}}},
     *      summary="get all items",
     *
     *      @OA\Parameter(
     *         name="CompanyId",
     *         in="query",
     *         description="id",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *        name="IsSold", in="query", required=false, @OA\Schema(type="boolean")
     *     ),
     *      @OA\Parameter(
     *          name="ProductIds[]",
     *          in="query",
     *          description="A list of product ids.",
     *          @OA\Schema(
     *            type="array",
     *            @OA\Items(type="integer")
     *          )
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
    function getItems(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateGetItems();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }
            $items = $this->itemInterface->getItems($request);
            
            return $this->handleReturn(true, $items, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

//

// == EDIT

    // ----- insert item
    /**
     * @OA\Post(
     * path="/Item/InsertItem",
     * tags={"Item"},
     * security={{"bearerToken":{}}},
     * summary="Create a new item",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to create a new item",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="product_id",description="productId"),
     *               @OA\Property(property="imei",description="imei"),
     *               @OA\Property(property="name",description="name"),
     *               @OA\Property(property="company_id",description="companyId"),
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
    function insertItem(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateInsertItem();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $item = $this->itemInterface->insertItem($request);
            DB::commit();

            return $this->handleReturn(true, $item, "Created successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- update item
    /**
     * @OA\Post(
     * path="/Item/UpdateItem",
     * tags={"Item"},
     * security={{"bearerToken":{}}},
     * summary="Update item",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to update a item",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="id", type="integer"),
     *               @OA\Property(property="product_id",description="productId"),
     *               @OA\Property(property="imei",description="imei"),
     *               @OA\Property(property="name",description="name"),
     *               @OA\Property(property="company_id",description="companyId"),
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

    function updateItem(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateUpdateItem();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $item = $this->itemInterface->updateItem($request);
            DB::commit();

            return $this->handleReturn(true, $item, "Updated successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//

// == DELETE

    // ----- delete item
    /**
     * @OA\Delete(
     * path="/Item/DeleteItem",
     * tags={"Item"},
     * security={{"bearerToken":{}}},
     * summary="Delete Item",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed to delete item",
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

    function deleteItem(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateDeleteItem();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $item = $this->itemInterface->deleteItem($request);
            DB::commit();

            return $this->handleReturn(true, $item, "Deleted successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//
}
