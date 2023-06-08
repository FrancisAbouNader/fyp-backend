<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;

class UserRepository implements UserInterface
{

    // ----- insert user
    function insertUser($request)
    {
        //-- create user
        $user = User::create([
            "email" => $request->email,
            "first_name" => $request->firstName,
            "last_name" => $request->lastName,
            "user_name" => $request->userName,
            "password" => $request->password,
            "role_id" => $request->userTypeId
        ]);

        //-- assign role to user by spatie and by assiging a new row in model_has_roles
        $user->assignRole($request->userTypeId);

        return $user;
    }

    // ----- update user
    function updateUser($request)
    {
        //-- update user
        return User::where('id', $request->id)->update([
            "first_name" => $request->firstName,
            "last_name" => $request->lastName,
            "user_name" => $request->userName,
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
