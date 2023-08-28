<?php

namespace App\Interfaces;

interface UserRequestInterface
{
    function insertUserRequest($request);
    function getPendingCustomerRequests($request);
}
