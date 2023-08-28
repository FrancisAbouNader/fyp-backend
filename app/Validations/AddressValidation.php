<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;

class AddressValidation
{
    function idValidation()
    {
        return Validator::make(request()->all(), [
            "Id" => "required|integer"
        ]);
    }
    function validateInsertAddress()
    {

        return Validator::make(request()->all(), [
            "address_line" => "required|string",
            "second_address_line" => "required_without:address_line|string",
            "city" => "required|string",
            "country" => "required|string"
        ]);
    }
    function validateUpdateAddress()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:addresses,id",
            "name" => "required|string"
        ]);
    }

    function validateDeleteAddress()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:addresses,id",
        ]);
    }
}
