<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use App\Validations\UserValidation;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
// == DECLARATION

    private $validateRequests, $userInterface;
    public function __construct(UserValidation $validateRequests, UserInterface $userInterface) {

        $this->middleware('auth:api', ['except' => ['login', 'insertUser']]);

        $this->validateRequests = $validateRequests;
        $this->userInterface = $userInterface;
    }
//

// == GET


    // ----- logout
    /**
     * @OA\Get(
     *      path="/Authentication/Logout",
     *      tags={"Auth"},
     *      summary="logout user",
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
    function logout()
    {
        try {
            auth()->logout();
            return $this->handleReturn(true, null, "Logged out Succesfully");
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

    // ----- get all users
    /**
     * @OA\Get(
     *      path="/User/GetUserByInfos",
     *      tags={"User"},
     *      summary="get all users",
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
    function getAllUsers(Request $request)
    {
        try {
            $users = $this->userInterface->getAllUsers($request);
            return $this->handleReturn(true, $users, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

    // ----- get User by id
    /**
     * @OA\Get(
     *      path="/User/GetUserById",
     *      tags={"User"},
     *      summary="get User",
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
    function getUserById(Request $request)
    {
        try {
            $validation = $this->validateRequests->idValidation();
            if ($validation->fails())
                return $this->handleReturn(false, null, $validation->errors()->first());
            

            $user = $this->userInterface->getUserById($request->Id);
            
            return $this->handleReturn(true, $user, null);
        } catch (Exception $ex) {
            return $this->reportError($ex);
        }
    }

//

// == EDIT

    // ----- login
    /**
     * @OA\Post(
     * path="/Authentication/UserAuthenticate",
     * tags={"Auth"},
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
    function login(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateLogin();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            $inputs = [
                "email" => strtolower(request()->email),
                "password" => request()->password
            ];
            DB::beginTransaction();
            $token = Auth::attempt($inputs);
            if (!$token) {
                return $this->handleReturn(true, null, "Invalid Password");
            }

            DB::commit();

            return $this->handleReturn(true, ["token" => $token, "user" => auth()->user()], "Logged in successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- insert user
    /**
     * @OA\Post(
     * path="/User/InsertUser",
     * tags={"User"},
     * security={{"bearerToken":{}}},
     * summary="Add User",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed add users",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="first_name"),
     *               @OA\Property(property="last_name"),
     *               @OA\Property(property="user_name"),
     *               @OA\Property(property="password"),
     *               @OA\Property(property="email"),
     *               @OA\Property(property="user_type_id", type="integer"),
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

    function insertUser(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateInsertUser();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $user = $this->userInterface->insertUser($request);
            DB::commit();

            return $this->handleReturn(true, $user, "Created successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

    // ----- update user
    /**
     * @OA\Post(
     * path="/User/UpdateUser",
     * tags={"User"},
     * security={{"bearerToken":{}}},
     * summary="Update User",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed add users",
     *            @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="id", type="integer"),
     *               @OA\Property(property="first_name"),
     *               @OA\Property(property="last_name"),
     *               @OA\Property(property="user_name"),
     *               @OA\Property(property="password"),
     *               @OA\Property(property="user_type_id", type="integer"),
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

    function updateUser(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateUpdateUser();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $user = $this->userInterface->updateUser($request);
            DB::commit();

            return $this->handleReturn(true, $user, "Updated successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//

// == DELETE

    // ----- delete user
    /**
     * @OA\Delete(
     * path="/User/DeleteUser",
     * tags={"User"},
     * security={{"bearerToken":{}}},
     * summary="Delete User",
     *     @OA\RequestBody(
     *           required=true,
     *           description="Body request needed add users",
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

    function deleteUser(Request $request)
    {
        try {
            //-- validation
            $validation =  $this->validateRequests->validateDeleteUser();
            if ($validation->fails()) {
                return $this->handleReturn(false, null, $validation->errors()->first());
            }

            DB::beginTransaction();
            $user = $this->userInterface->deleteUser($request);
            DB::commit();

            return $this->handleReturn(true, $user, "Updated successfully");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->reportError($ex);
        }
    }

//
}
