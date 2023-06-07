<?php

namespace App\Interfaces;

interface UserInterface
{
    function insertUser($request);
    function updateUser($request);
    function deleteUser($request);
}
