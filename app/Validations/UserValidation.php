<?php

namespace App\Validations;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserValidation
{
    function getAllEmployeesValidation()
    {
        return Validator::make(request()->all(), [
            "FirstName" => "nullable|string",
            "CustomerId" => "nullable|integer|exists:companies,id",
            "UserTypeId" => "nullable|integer|exists:user_types,id",
        ]);
    }

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
            "phone_number" => "nullable|string",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "user_name" => "required|string",
            "user_type_id" => "required|integer|exists:roles,id",
            "company_id" => "nullable|integer|exists:companies,id"
        ]);
    }

    function validateCreateEmployee()
    {
        return Validator::make(request()->all(), [
            "email" => "required|email|unique:users,email",
            "first_name" => "required|string",
            "phone_number" => "nullable|string",
            "last_name" => "required|string",
            "user_name" => "required|string",
            "addresses" => "nullable|array",
            "addresses.*.address_line" => "required|string",
            "addresses.*.second_address_line" => "required_without:address_line|string",
            "addresses.*.city" => "required|string",
            "addresses.*.country" => "required|string"

        ]);
    }

    function validateUpdateEmployee()
    {
        return Validator::make(request()->all(), [
            "id" => "required|integer|exists:users,id",
            "first_name" => "required|string",
            "phone_number" => "nullable|string",
            "last_name" => "required|string",
            "user_name" => "required|string",
            "addresses" => "nullable|array",
            "addresses.*.id" => "nullable|integer|exists:addresses,id,model_id," . request()->id . ",model_type," . User::class,
            "addresses.*.address_line" => "required|string",
            "addresses.*.second_address_line" => "required_without:address_line|string",
            "addresses.*.city" => "required|string",
            "addresses.*.country" => "required|string"

        ]);
    }

    function validateUpdateUser()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:users,id,deleted_at,NULL",
            "password" => "required|string",
            "first_name" => "required|string",
            "phone_number" => "nullable|string",
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
