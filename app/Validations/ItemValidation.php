<?php

namespace App\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ItemValidation
{
    function idValidation()
    {
        return Validator::make(request()->all(), [
            "Id" => "required|integer"
        ]);
    }
    
    function validateInsertItem()
    {

        return Validator::make(request()->all(), [
            "product_id" => "required|integer|unique:products,id,deleted_at,NULL",
            'imei' => "required|string",
            'name' => "required|string",
            'company_id' => "required|integer|exists:companies,id"
        ]);
    }


    function validateUpdateItem()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:items,id,deleted_at,NULL",
            "product_id" => "required|integer|exists:products,id,deleted_at,NULL",
            'imei' => "required|string",
            'name' => "required|string",
            'company_id' => "required|integer|exists:companies,id"
        ]);
    }

    function validateDeleteItem()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:items,id,deleted_at,NULL",
        ]);
    }

}
