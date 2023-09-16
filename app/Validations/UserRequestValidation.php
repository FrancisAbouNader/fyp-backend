<?php

namespace App\Validations;

use App\Models\UserRequest;
use Illuminate\Support\Facades\Validator;

class UserRequestValidation
{

    function validateChangeRequest()
    {
        $validator = Validator::make(request()->all(), [
            "user_request_id"                            => "required|integer|exists:user_requests,id",
        ]);

        if($validator->fails())
            return $validator;

        return Validator::make(request()->all(), [
                "items"                                      => "required|array",
                "items.*.item_id"                            => "required|distinct|integer|exists:items,id,is_sold,FALSE,ownerable_id," . UserRequest::find(request()->user_request_id)->company_id,
                "items.*.product_id"                         => "required|integer|exists:products,id|exists:user_request_products,product_id,user_request_id," . request()->user_request_id,
        ]);
    }

    function validateGetCustomerRequests()
    {
        return Validator::make(request()->all(), [
            "per_page"    => "nullable|integer",
            "name"        => "nullable|string",
            "RequestStatusId"   => "nullable|integer|exists:request_statuses,id",
            "company_id"   => "nullable|integer|exists:companies,id"
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
