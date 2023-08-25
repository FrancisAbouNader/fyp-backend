<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;

class UserValidation
{
    function idValidation()
    {
        return Validator::make(request()->all(), [
            "Id" => "required|integer"
        ]);
    }
    
    function validateLogin()
    {
        request()->merge([
            'email' => strtolower(request()->email)
        ]);

        return Validator::make(request()->all(), [
            "email" => "required|email|exists:users,email,deleted_at,NULL",
            "password" => "required|string"
        ]);
    }

    function validateInsertUser()
    {
        return Validator::make(request()->all(), [
            "email" => "required|email|unique:users,email",
            "password" => "required|string",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "user_name" => "required|string",
            "user_type_id" => "required|integer|exists:roles,id"
        ]);
    }
    function validateUpdateUser()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:users,id,deleted_at,NULL",
            "password" => "required|string",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "user_name" => "required|string",
            "user_type_id" => "required|integer|exists:roles,id"
        ]);
    }

    function validateDeleteUser()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:users,id,deleted_at,NULL",
        ]);
    }

    function validateGetCustomerRequests()
    {
        return Validator::make(request()->all(), [
            "per_page"    => "nullable|integer",
            "name"        => "nullable|string"
        ]);
    }
}
