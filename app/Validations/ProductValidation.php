<?php

namespace App\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProductValidation
{
    function validateInsertProduct()
    {

        return Validator::make(request()->all(), [
            "name" => "required|string|unique:products,name,deleted_at,NULL",
            'model_number' => "required|integer",
            'package_height' => "required|integer",
            'package_width' => "required|integer",
            'package_length' => "required|integer",
            'package_weight' => "required|integer",
            'product_height'=>"required|integer",
            'product_width' => "required|integer",
            'product_length' =>"required|integer",
            'product_weight' => "required|integer",
            'description' => "required|string|",
            "brand_id" => "required|integer",
            "product_type_id" =>"required|integer",
        ]);
    }


    function validateUpdateProduct()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:products,id,deleted_at,NULL",
            "name" => "required|string|unique:products,name,deleted_at,NULL",
            'model_number' => "required|integer",
            'package_height' => "required|integer",
            'package_width' => "required|integer",
            'package_length' => "required|integer",
            'package_weight' => "required|integer",
            'product_height'=>"required|integer",
            'product_width' => "required|integer",
            'product_length' =>"required|integer",
            'product_weight' => "required|integer",
            'description' => "required|string|",
            "brand_id" => "required|integer",
            "product_type_id" =>"required|integer",
        ]);
    }

    function validateDeleteProduct()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:products,id,deleted_at,NULL",
        ]);
    }

}
