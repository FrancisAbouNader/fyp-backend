<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;

class UserValidation
{
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
            "firstName" => "required|string",
            "lastName" => "required|string",
            "userName" => "required|string",
            "userTypeId" => "required|integer|exists:roles,id"
        ]);
    }
    function validateUpdateUser()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:users,id,deleted_at,NULL",
            "password" => "required|string",
            "firstName" => "required|string",
            "lastName" => "required|string",
            "userName" => "required|string",
            "userTypeId" => "required|integer|exists:roles,id"
        ]);
    }

    function validateDeleteUser()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:users,id,deleted_at,NULL",
        ]);
    }
}
