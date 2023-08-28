<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
use App\Models\UserRequest;

class UserRepository implements UserInterface
{

    function getUserById($id)
    {
        return User::where('id', $id)->with('company')->with('role')->first();
    }
    // ----- get all users
    function getAllUsers($request)
    {
        return User::with('company')->with('role')->get();
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

    // ----- insert user
    function insertUser($request)
    {
        //-- create user
        $user = User::create([
            "email" => $request->email,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "user_name" => $request->user_name,
            "password" => $request->password,
            "role_id" => $request->user_type_id
        ]);

        //-- assign role to user by spatie and by assiging a new row in model_has_roles
        $user->assignRole($request->user_type_id);

        return $user;
    }

    // ----- insert customer
    function insertCustomer($request)
    {
        //-- create user
        $user = User::create([
            "email" => $request->email,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "user_name" => $request->user_name,
            "role_id" => 3
        ]);

        //-- assign role to user by spatie and by assiging a new row in model_has_roles
        $user->assignRole(3);

        return $user;
    }

    // ----- update user
    function updateUser($request)
    {
        //-- update user
        return User::where('id', $request->id)->update([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "user_name" => $request->user_name,
            "password" => $request->password,
        ]);
    }
    

    // --- delete user
    function deleteUser($request)
    {
        return User::where('id', $request->id)->delete();
    }
//

}
