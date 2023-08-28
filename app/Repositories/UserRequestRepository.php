<?php

namespace App\Repositories;

use App\Models\UserRequest;
use App\Interfaces\UserRequestInterface;

class UserRequestRepository implements UserRequestInterface
{

    // ----- insert user request
    function insertUserRequest($request)
    {
        $user_request = UserRequest::create([
            "user_id" => $request->user_id,
            "company_id" => $request->company_id,
            "request_status_id" => 1
        ]);

        $user_request->products()->attach($request->products);

        return $user_request;

    }

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
