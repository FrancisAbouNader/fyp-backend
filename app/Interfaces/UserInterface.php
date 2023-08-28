<?php

namespace App\Interfaces;

interface UserInterface
{
    function getAllUsers($request);
    function getAllEmployees($request);
    function getUserById($id);
    function getPendingCustomerRequests($request);

    function insertUser($request);
    function insertEmployee($request);
    function updateEmployee($request);
    function updateUser($request);
    function deleteUser($request);
}
