<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;

class UserRequestValidation
{

    function validateGetCustomerRequests()
    {
        return Validator::make(request()->all(), [
            "per_page"    => "nullable|integer",
            "name"        => "nullable|string"
        ]);
    }
}
