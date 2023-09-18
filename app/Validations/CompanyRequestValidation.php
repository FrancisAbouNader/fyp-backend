<?php

namespace App\Validations;

use App\Models\CompanyRequest;
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

    function validateChangeRequest()
    {
        $validator = Validator::make(request()->all(), [
            "company_request_id"                         => "required|integer|exists:company_requests,id",
        ])->stopOnFirstFailure(true);

        if($validator->fails())
            return $validator;
            
        return Validator::make(request()->all(), [
            "items"                                      => "required|array",
            "items.*.item_id"                            => "required|distinct|integer|exists:items,id,is_sold,FALSE,ownerable_id", CompanyRequest::find(request()->company_request_id)->company_from_id,
            "items.*.product_id"                         => "required|integer|exists:products,id",
        ])->stopOnFirstFailure(true);
    }
}
