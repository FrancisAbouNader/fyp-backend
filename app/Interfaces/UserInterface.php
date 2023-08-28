<?php

namespace App\Interfaces;

interface UserInterface
{
    function getAllUsers($request);
    function getUserById($id);
    function getPendingCustomerRequests($request);

    function insertUser($request);
    function insertCustomer($request);
    function updateUser($request);
    function deleteUser($request);
}
