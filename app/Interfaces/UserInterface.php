<?php

namespace App\Interfaces;

interface UserInterface
{
    function getPendingCustomerRequests($request);

    function insertUser($request);
    function updateUser($request);
    function deleteUser($request);
}
