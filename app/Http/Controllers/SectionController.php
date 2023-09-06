<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\SectionInterface;
use App\Validations\SectionValidation;

class SectionController extends Controller
{

// == DECLARATION

    private $validateRequests, $sectionInterface;
    public function __construct(SectionValidation $validateRequests, SectionInterface $sectionInterface) {

        $this->middleware('auth:api', ['except' => []]);

        $this->validateRequests = $validateRequests;
        $this->sectionInterface = $sectionInterface;
    }
//

// == GET

    // ----- get all sections
    /**
     * @OA\Get(
     *      path="/Admin/GetSections",
     *      tags={"Section"},
     *      summary="get all sections",
     *      security={{"bearerToken":{}}},
     *
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
    function getAllSections(Request $request)
    {
        try {
            $validation = $this->validateRequests->validateGetSections();
            if ($validation->fails())
                return $this->handleReturn(false, null, $validation->errors()->first());

            $Sections = $this->sectionInterface->getAllSections($request);
            return $this->handleReturn(true, $Sections, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }


    // ----- get section by id
    /**
     * @OA\Get(
     *      path="/Admin/GetSectionById",
     *      tags={"Section"},
     *      summary="get Section",
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
    function getSectionById(Request $request)
    {
        try {
            $validation = $this->validateRequests->idValidation();
            if ($validation->fails())
                return $this->handleReturn(false, null, $validation->errors()->first());
            

            $Section = $this->sectionInterface->getSectionById($request->Id);
            
            return $this->handleReturn(true, $Section, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

//

// == EDIT

    // ----- insert section
    /**
     * @OA\Post(
     * path="/Admin/InsertSection",
     * tags={"Section"},
     * summary="insert a new section",
     *     @OA\RequestBody(
     *           required=true,
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="company_id"),
     *               @OA\Property(property="name"),
     *               @OA\Property(property="product_id"),
     *               @OA\Property(property="order"),
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
    function insertSection(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateInsertSection();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $Section = $this->sectionInterface->insertSection($request);
            DB::commit();

            return $this->handleReturn(true, $Section, "Created successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- update section
    /**
     * @OA\Post(
     * path="/Admin/UpdateSection",
     * tags={"Section"},
     * security={{"bearerToken":{}}},
     * summary="Update Section",
     *     @OA\RequestBody(
     *           required=true,
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="id", type="integer"),
     *               @OA\Property(property="company_id"),
     *               @OA\Property(property="name"),
     *               @OA\Property(property="product_id"),
     *               @OA\Property(property="order"),
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

    function updateSection(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateUpdateSection();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $Section = $this->sectionInterface->updateSection($request);
            DB::commit();

            return $this->handleReturn(true, $Section, "Updated successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- swap sections
    /**
     * @OA\Post(
     * path="/Admin/SwapSections",
     * tags={"Section"},
     * security={{"bearerToken":{}}},
     *     @OA\RequestBody(
     *           required=true,
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="first_section_id", type="integer"),
     *               @OA\Property(property="second_section_id",  type="integer"),
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
    function swapSections(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateSwapSections();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $Section = $this->sectionInterface->swapSections($request);
            DB::commit();

            return $this->handleReturn(true, $Section, "Updated successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//

}
