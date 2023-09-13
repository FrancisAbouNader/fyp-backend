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
            "companyId"   => "required|integer|exists:companies,id",
            "companyToId"   => "nullable|integer|exists:companies,id",
            "RequestStatusId"   => "nullable|integer|exists:request_statuses,id"
        ]);
    }

    function validateinsertCompanyRequest()
    {
        return Validator::make(request()->all(), [
            "company_from_id"                   => "required|integer|exists:companies,id",
            "company_to_id"                     => "required|integer|exists:companies,id",
            "products"                          => "required|array",
            "products.*.product_id"             => "required|integer|exists:products,id",
            "products.*.quantity"               => "required|integer|min:1",
        ]);
    }
}
