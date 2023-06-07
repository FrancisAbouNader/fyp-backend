<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/roles', [RoleController::class, 'getAllRoles']);

Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'Authentication',
    ],
    function () {
        //-- Auth Controller
        Route::get('/Logout', [UserController::class, 'logout']);
        Route::post('/UserAuthenticate', [UserController::class, 'login']);
    }
);
Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'User',
    ],
    function () {
        //-- Auth Controller
        Route::post('/InsertUser', [UserController::class, 'insertUser']);
        Route::post('/UpdateUser', [UserController::class, 'UpdateUser']);
        Route::delete('/DeleteUser', [UserController::class, 'DeleteUser']);
    }
);
