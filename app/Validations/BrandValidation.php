<?php

namespace App\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BrandValidation
{
    function idValidation()
    {
        return Validator::make(request()->all(), [
            "Id" => "required|integer"
        ]);
    }
    function validateInsertBrand()
    {

        return Validator::make(request()->all(), [
            "name" => "required|string"
        ]);
    }
    function validateUpdateBrand()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:brands,id,deleted_at,NULL",
            "name" => "required|string"
        ]);
    }

    function validateDeleteBrand()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:brands,id,deleted_at,NULL",
        ]);
    }
}
