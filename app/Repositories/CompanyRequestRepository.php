<?php

namespace App\Repositories;

use App\Interfaces\CompanyRequestInterface;
use App\Models\CompanyRequest;

class CompanyRequestRepository implements CompanyRequestInterface
{

    // ----- insert company request
    function insertCompanyRequest($request)
    {
        $company_request = CompanyRequest::create([
            "company_to_id" => $request->company_to_id,
            "company_from_id" => $request->company_from_id,
            "request_status_id" => 1
        ]);

        $company_request->products()->attach($request->products);

        return $company_request;
    }

    // ----- get pending company requests
    function getPendingCompanyRequests($request)
    {
        $company_requests = CompanyRequest::where("request_status_id" , 1)->where('company_from_id', $request->companyId)->with('companyTo')->with('companyFrom')->with('requestStatus')->with('products');

        if(isset($request->name))
        {
            $company_requests = $company_requests->whereHas('company', function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%' . $request->name . '%');
            });
        }

        if(isset($request->CompanyToId))
        {
            $company_requests = $company_requests->where('company_to_id', $request->CompanyToId);
        }

        if(isset($request->RequestStatusId))
        {
            $company_requests = $company_requests->where('request_status_id', $request->RequestStatusId);
        }

        return isset($request->per_page) ? $company_requests->paginate($request->per_page) : $company_requests->get();
    }

}
