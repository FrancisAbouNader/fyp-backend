<?php

namespace App\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProductTypeValidation
{
    function idValidation()
    {
        return Validator::make(request()->all(), [
            "Id" => "required|integer"
        ]);
    }
    
    function validateInsertProductType()
    {

        return Validator::make(request()->all(), [
            "name" => "required|string|unique:product_types,name"
        ]);
    }


    function validateUpdateProductType()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:product_types,id,deleted_at,NULL",
            "name" => "required|string"
        ]);
    }

    function validateDeleteProductType()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:product_types,id,deleted_at,NULL",
        ]);
    }

}
