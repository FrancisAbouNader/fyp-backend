<?php

namespace App\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CompanyValidation
{
    function validateInsertCompany()
    {

        return Validator::make(request()->all(), [
            "name" => "required|string",
            "location" => "required|string"
        ]);
    }

    function validateUpdateCompany()
    {
        return Validator::make(request()->all(), [
            "name" => "required|string",
            "location" => "required|string"
        ]);
    }

    function validateDeleteCompany()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:companies,id,deleted_at,NULL",
        ]);
    }

}
