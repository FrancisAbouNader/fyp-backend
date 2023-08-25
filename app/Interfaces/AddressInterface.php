<?php

namespace App\Interfaces;

interface AddressInterface
{
    function getAddresses($request);
    function getUserAddresses($request);
    function getAddressById($id);
    function insertAddress($request);
    function updateAddress($request);
    function deleteAddress($request);
}
