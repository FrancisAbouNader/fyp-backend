<?php

namespace App\Repositories;

use App\Interfaces\CompanyRequestInterface;
use App\Models\CompanyRequest;

class CompanyRequestRepository implements CompanyRequestInterface
{

    // ----- get pending company requests
    function getPendingCompanyRequests($request)
    {
        $company_requests = CompanyRequest::where("request_status_id" , 1)->where('company_from_id', $request->companyId)->with('companyTo')->with('companyFrom');

        if(isset($request->name))
        {
            $company_requests = $company_requests->whereHas('company', function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%' . $request->name . '%');
            });
        }

        return isset($request->per_page) ? $company_requests->paginate($request->per_page) : $company_requests->get();
    }

}
