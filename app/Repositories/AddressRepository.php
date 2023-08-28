<?php

namespace App\Repositories;

use App\Models\Address;
use App\Interfaces\AddressInterface;
use App\Models\User;

class AddressRepository implements AddressInterface
{
    // ----- get Addresss
    function getAddresses($request)
    {
        return Address::get();
    }

    // ----- get Addresss
    function getUserAddresses($request)
    {
        return Address::where('model_id', $request->Id)->where('model_type', User::class)->get();
    }


    // ----- get Address by id 
    function getAddressById($id)
    {
        return Address::where('id', $id)->first();
    }
    
    // ----- insert Address
    function insertAddress($request)
    {
        //-- insert Address
        $Address = Address::create([
            "address_line" => $request->address_line,
            "second_address_line" => $request->second_address_line,
            "city" => $request->city,
            "country" => $request->country,
            "model_id" => $request->model_id,
            "model_type" => $request->model_type,
        ]);

        return $Address;
    }

    // ----- insert Addresses
    function insertAddresses($request)
    {
        //-- insert Addresses
        foreach($request->addresses as $address)
        {
            Address::create([
                "address_line" => $address->address_line,
                "second_address_line" => $address->second_address_line,
                "city" => $address->city,
                "country" => $address->country,
                "model_id" => $request->model_id,
                "model_type" => $request->model_type,
            ]);
        }
    }

    // ----- update employee Addresses
    function updateEmployeeAddresses($request)
    {
        $addresses_ids_to_delete = [];
        if(isset($request->addresses) && count($request->addresses))
        {
            foreach($request->addresses as $address)
            {
                if(isset($address->id))
                {
                    $new_add = Address::where('id', $address->id)->update([
                        "address_line" => $address->address_line,
                        "second_address_line" => $address->second_address_line,
                        "city" => $address->city,
                        "country" => $address->country,
                        "model_id" => $request->model_id,
                        "model_type" => $request->model_type,
                    ]);
                    $addresses_ids_to_delete[] = $address->id;
                }
                else
                {
                    $new_add = Address::create([
                        "address_line" => $address->address_line,
                        "second_address_line" => $address->second_address_line,
                        "city" => $address->city,
                        "country" => $address->country,
                        "model_id" => $request->model_id,
                        "model_type" => $request->model_type,
                    ]);
                    $addresses_ids_to_delete[] = $new_add->id;
                }
            }
        }
        Address::where('model_id', $request->model_id)->where('model_type', $request->model_type)->whereNotIn('id', $addresses_ids_to_delete)->delete();
    }

    // ----- update Address
    function updateAddress($request)
    {
        //-- update Address
        return Address::where('id', $request->id)->update([
            "address_line" => $request->address_line,
            "second_address_line" => $request->second_address_line,
            "city" => $request->city,
            "country" => $request->country,
        ]);
    }
    

    // ----- delete Address
    function deleteAddress($request)
    {
        return Address::where('id', $request->id)->delete();
    }
//

}
