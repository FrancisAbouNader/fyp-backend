<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\User;
use App\Models\UserRequest;
use App\Models\UserRequestProduct;
use App\Interfaces\UserRequestInterface;
use Illuminate\Support\Facades\DB;

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
        $customer_requests = UserRequest::with('requestStatus')->with('user')->with('products');

        if(isset($request->name))
        {
            $customer_requests = $customer_requests->whereHas('user', function ($query) use ($request) {
                $query->where('first_name', 'ILIKE', '%' . $request->name . '%')
                    ->orWhere('last_name', 'ILIKE', '%' . $request->name . '%');
            });
        }

        if(isset($request->RequestStatusId))
        {
            $customer_requests = $customer_requests->where('request_status_id', $request->RequestStatusId);
        }

        if(isset($request->company_id))
        {
            $customer_requests = $customer_requests->where('company_id', $request->company_id);
        }

        return isset($request->per_page) ? $customer_requests->paginate($request->per_page) : $customer_requests->get();
    }

    function changeRequestStatus($request)
    {
        $user_request = UserRequest::find($request->user_request_id);

        foreach($request->items as $item)
        {
            UserRequestProduct::where('user_request_id', $user_request->id)->where('product_id', $item["product_id"])->first()->items()->attach($item["item_id"]);
            
            Item::where('id', $item["item_id"])->update([
                "ownerable_id" => $user_request->user_id,
                "ownerable_type" => User::class,
                "is_sold" => true
            ]);

            $sales = DB::table('company_product_sales')->where('company_id', $user_request->company_id)->where('product_id', $item["product_id"])->first();
            if(isset($sales))
            {
                DB::table('company_product_sales')->where('company_id', $user_request->company_id)->where('product_id', $item["product_id"])->update([
                    "quantity" => $sales->quantity + 1
                ]);
            }
            else {
                DB::table('company_product_sales')->insert([
                    "quantity" => 1,
                    "company_id" => $user_request->company_id,
                    "product_id" => $item["product_id"]
                ]);
            }
        }

        $user_request->request_status_id = 2;
        $user_request->update();
    }

}
