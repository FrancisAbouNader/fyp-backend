<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;

class CompanyRequestValidation
{

    function validateGetCompanyRequests()
    {
        return Validator::make(request()->all(), [
            "per_page"    => "nullable|integer",
            "name"        => "nullable|string",
            "companyId"   => "required|integer|exists:companies,id"
        ]);
    }
}
