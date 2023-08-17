<?php

namespace App\Repositories;

use App\Models\UserRequest;
use App\Interfaces\UserRequestInterface;

class UserRequestRepository implements UserRequestInterface
{

    // ----- get customer requests
    function getPendingCustomerRequests($request)
    {
        $customer_requests = UserRequest::where("request_status_id" , 1);

        if(isset($request->name))
        {
            $customer_requests = $customer_requests->whereHas('user', function ($query) use ($request) {
                $query->where('first_name', 'ILIKE', '%' . $request->name . '%')
                    ->orWhere('last_name', 'ILIKE', '%' . $request->name . '%');
            });
        }

        return isset($request->per_page) ? $customer_requests->paginate($request->per_page) : $customer_requests->get();
    }

}
