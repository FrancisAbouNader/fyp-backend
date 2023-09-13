<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;

class UserRequestValidation
{

    function validateGetCustomerRequests()
    {
        return Validator::make(request()->all(), [
            "per_page"    => "nullable|integer",
            "name"        => "nullable|string",
            "RequestStatusId"   => "nullable|integer|exists:request_statuses,id"
        ]);
    }

    function validateinsertUserRequest()
    {
        return Validator::make(request()->all(), [
            "user_id"                           => "required|integer|exists:users,id",
            "company_id"                        => "required|integer|exists:companies,id",
            "products"                          => "required|array",
            "products.*.product_id"             => "required|integer|exists:products,id",
            "products.*.quantity"               => "required|integer|min:1",
        ]);
    }
}
