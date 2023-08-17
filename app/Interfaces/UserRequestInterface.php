<?php

namespace App\Interfaces;

interface UserRequestInterface
{
    function getPendingCustomerRequests($request);
}
