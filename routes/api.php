<?php

use App\Http\Controllers\BrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductTypeController;
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
        Route::post('/InsertUser', [UserController::class, 'insertUser']);
        Route::post('/UpdateUser', [UserController::class, 'UpdateUser']);
        Route::delete('/DeleteUser', [UserController::class, 'DeleteUser']);
    }
);

Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'Admin',
    ],
    function () {
        Route::get('/GetBrands', [BrandController::class, 'getBrands']);
        Route::post('/InsertBrand', [BrandController::class, 'insertBrand']);
        Route::post('/UpdateBrand', [BrandController::class, 'updateBrand']);
        Route::delete('/DeleteBrand', [BrandController::class, 'deleteBrand']);
        Route::get('/GetProductTypes', [ProductTypeController::class, 'getProductType']);
        Route::post('/InsertProductType', [ProductTypeController::class, 'insertProductType']);
        Route::post('/UpdateProductType', [ProductTypeController::class, 'updateProductType']);
        Route::delete('/DeleteProductType', [ProductTypeController::class, 'deleteProductType']);
    }
);


Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'Product',
    ],
    function () {
        Route::get('/GetProduct', [ProductController::class, 'getProduct']);
        Route::post('/InsertProduct', [ProductController::class, 'insertProduct']);
        Route::post('/UpdateProduct', [ProductController::class, 'updateProduct']);
        Route::delete('/DeleteProduct', [ProductController::class, 'deleteProduct']);
       
    }
);
