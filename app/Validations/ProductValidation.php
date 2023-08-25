<?php

namespace App\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProductValidation
{
    function idValidation()
    {
        return Validator::make(request()->all(), [
            "Id" => "required|integer"
        ]);
    }
    
    function validateInsertProduct()
    {

        return Validator::make(request()->all(), [
            "productName" => "required|string|unique:products,name,NULL,id,deleted_at,NULL",
            'modelNumber' => "required|integer",
            'packageHeight' => "required|integer",
            'packageWidth' => "required|integer",
            'packageLength' => "required|integer",
            'packageWeight' => "required|integer",
            'productHeight'=>"required|integer",
            'productWidth' => "required|integer",
            'productLength' =>"required|integer",
            'productWeight' => "required|integer",
            'description' => "required|string",
            "brandId" => "required|integer",
            "productTypeId" =>"required|integer",
        ]);
    }


    function validateUpdateProduct()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:products,id,deleted_at,NULL",
            "productName" => "required|string|unique:products,name," . request()->id,
            'modelNumber' => "required|integer",
            'packageHeight' => "required|integer",
            'packageWidth' => "required|integer",
            'packageLength' => "required|integer",
            'packageWeight' => "required|integer",
            'productHeight'=>"required|integer",
            'productWidth' => "required|integer",
            'productLength' =>"required|integer",
            'productWeight' => "required|integer",
            'description' => "required|string",
            "brandId" => "required|integer",
            "productTypeId" =>"required|integer",
        ]);
    }

    function validateDeleteProduct()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:products,id,deleted_at,NULL",
        ]);
    }

}
