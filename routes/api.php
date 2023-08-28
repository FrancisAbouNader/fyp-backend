<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Companycontroller;
use App\Http\Controllers\ProductController;
use App\Interfaces\CompanyRequestInterface;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\UserRequestController;
use App\Http\Controllers\CompanyRequestController;

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
        Route::get('/GetUserByInfos', [UserController::class, 'getAllUsers']);
        Route::get('/GetUserById', [UserController::class, 'getUserById']);
        Route::post('/InsertUser', [UserController::class, 'insertUser']);
        Route::post('/InsertCustomer', [UserController::class, 'insertCustomer']);
        Route::post('/UpdateUser', [UserController::class, 'UpdateUser']);
        Route::delete('/DeleteUser', [UserController::class, 'DeleteUser']);
    }
);

Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'Employee',
    ],
    function () {
        Route::post('/AddEmployee', [UserController::class, 'addEmployee']);
        Route::post('/UpdateEmployee', [UserController::class, 'updateEmployee']);
    }
);

Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'Admin',
    ],
    function () {
        Route::get('/GetBrands', [BrandController::class, 'getBrands']);
        Route::get('/GetBrandById', [BrandController::class, 'getBrandById']);
        Route::post('/InsertBrand', [BrandController::class, 'insertBrand']);
        Route::post('/UpdateBrand', [BrandController::class, 'updateBrand']);
        Route::delete('/DeleteBrand', [BrandController::class, 'deleteBrand']);
        Route::get('/GetProductTypes', [ProductTypeController::class, 'getProductType']);
        Route::get('/GetProductTypeById', [ProductTypeController::class, 'getProductTypeById']);
        Route::post('/InsertProductType', [ProductTypeController::class, 'insertProductType']);
        Route::post('/UpdateProductType', [ProductTypeController::class, 'updateProductType']);
        Route::delete('/DeleteProductType', [ProductTypeController::class, 'deleteProductType']);

        Route::get('/GetPendingCustomerRequests', [UserRequestController::class, 'getPendingCustomerRequests']);
        Route::post('/ChangeRequestStatus', [UserRequestController::class, 'changeRequestStatus']);

        Route::get('/GetPendingCompanyRequests', [CompanyRequestController::class, 'getPendingCompanyRequests']);
        Route::post('/ChangeCompanRequestStatus', [CompanyRequestController::class, 'changeRequestStatus']);

    }
);


Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'Product',
    ],
    function () {
        Route::get('/GetProducts', [ProductController::class, 'getProducts']);
        Route::get('/GetProductById', [ProductController::class, 'getProductById']);
        Route::post('/InsertProduct', [ProductController::class, 'insertProduct']);
        Route::post('/UpdateProduct', [ProductController::class, 'updateProduct']);
        Route::delete('/DeleteProduct', [ProductController::class, 'deleteProduct']);
       
    }
);

Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'Address',
    ],
    function () {
        Route::get('/GetAddresses', [AddressController::class, 'getAddresses']);
        Route::get('/GetUserAddresses', [AddressController::class, 'GetUserAddresses']);
        Route::get('/GetAddressById', [AddressController::class, 'getAddressById']);
        Route::post('/InsertAddress', [AddressController::class, 'insertAddress']);
        Route::post('/UpdateAddress', [AddressController::class, 'updateAddress']);
        Route::delete('/DeleteAddress', [AddressController::class, 'deleteAddress']);
       
    }
);

Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'Company',
    ],
    function () {
        Route::get('/GetCompanies', [CompanyController::class, 'getCompanies']);
        Route::get('/GetCompanyById', [CompanyController::class, 'getCompanyById']);
        Route::post('/InsertCompany', [CompanyController::class, 'insertCompany']);
        Route::post('/UpdateCompany', [CompanyController::class, 'updateCompany']);
        Route::delete('/DeleteCompany', [CompanyController::class, 'deleteCompany']);
       
    }
);

Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'Brand',
    ],
    function () {
        Route::get('/GetBrands', [BrandController::class, 'getBrands']);
        Route::post('/InsertBrand', [BrandController::class, 'insertBrand']);
        Route::post('/UpdateBrand', [BrandController::class, 'updateBrand']);
        Route::delete('/DeleteBrand', [BrandController::class, 'deleteBrand']);
       
    }
);

Route::group(
    [
        'middleware' => ['api'],
        'prefix' => 'Item',
    ],
    function () {
        Route::get('/GetItems', [ItemController::class, 'getItems']);
        Route::get('/GetItemById', [ItemController::class, 'getItemById']);
        Route::post('/InsertItem', [ItemController::class, 'insertItem']);
        Route::post('/UpdateItem', [ItemController::class, 'updateItem']);
        Route::delete('/DeleteItem', [ItemController::class, 'deleteItem']);
       
    }
);