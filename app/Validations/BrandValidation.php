<?php

namespace App\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BrandValidation
{
    function validateInsertBrand()
    {

        return Validator::make(request()->all(), [
            "name" => "required|string|unique:brands,name,deleted_at,NULL"
        ]);
    }
    function validateUpdateBrand()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:brands,id,deleted_at,NULL",
            "name" => "required|string"
        ]);
    }

    function validateDeleteBrand()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:brands,id,deleted_at,NULL",
        ]);
    }
    function validateResetPasswordByOtp()
    {
        return Validator::make(request()->all(), [
            'user_type_id' => 'required|integer|exists:user_types,id',
            'email' => ['required', 'email', 'string', Rule::exists('users', 'email')->where(function ($query) {
                $query->where('provider', '2use');
                $query->where('user_type_id', request()->user_type_id);
                $query->whereNotNull('phone_number');
                $query->whereNotNull('password');
            })]
        ]);
    }

    function validateResetPasswordForm()
    {
        return Validator::make(request()->all(), [
            'password' => "required|string|confirmed",
            'token' => "required|string|exists:password_resets,token",
        ]);
    }

    public function validateSignUp()
    {
        return Validator::make(request()->all(), [
            "email" => "required|email|unique:users,email,null,id,user_type_id," . 5,
            "full_name" => "required|string",
            "password" => "required|string|confirmed",
            "country_id" => "required|integer|exists:countries,id",
            "phone_number" => "required|string"
        ]);
    }

    function validateVerifyEmail()
    {
        return Validator::make(request()->all(), [
            "user_id" => "required|integer|exists:email_verifications,user_id",
            "token" => 'required|string|exists:email_verifications,token,user_id,' . request()->user_id
        ]);
    }

    function validateSocialiteRedirect()
    {
        return Validator::make(request()->all(), [
            "provider" => ['required','string','regex:(google|facebook|apple)'],
            "token" => "nullable|string",
            "path" => "nullable|string"
        ],
        [
            'provider.regex' => "The provider must be google, facebook, or apple"
        ]);
    }

    function validateVerifyResetPasswordToken()
    {
        return Validator::make(request()->all(), [
            'user_type_id' => 'required|integer|exists:user_types,id',
            'email' => 'required|email|string|exists:password_resets,email,user_type_id,'.request()->user_type_id,
            'token' => 'required|exists:password_resets,token,email,' . request()->email,
        ]);
    }
}
