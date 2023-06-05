<?php

namespace App\Repositories;

use App\Models\Role;
use App\Interfaces\RoleInterface;

class RoleRepository implements RoleInterface
{

// == GET

    // ----- get all roles
    function getAllRoles()
    {
        return Role::get();
    }
//

}
