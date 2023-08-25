<?php

namespace App\Interfaces;

interface UserInterface
{
    function getAllUsers($request);
    function getUserById($id);
    function getPendingCustomerRequests($request);

    function insertUser($request);
    function updateUser($request);
    function deleteUser($request);
}
