<?php

namespace App\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ItemValidation
{
    function validateInsertItem()
    {

        return Validator::make(request()->all(), [
            "productId" => "required|integer|unique:products,id,deleted_at,NULL",
            'imei' => "required|string",
            'name' => "required|string",
            'companyId' => "required|integer|exists:companies,id"
        ]);
    }


    function validateUpdateItem()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:items,id,deleted_at,NULL",
            "productId" => "required|integer|exists:products,id,deleted_at,NULL",
            'imei' => "required|string",
            'name' => "required|string",
            'companyId' => "required|integer|exists:companies,id"
        ]);
    }

    function validateDeleteItem()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:items,id,deleted_at,NULL",
        ]);
    }

}
