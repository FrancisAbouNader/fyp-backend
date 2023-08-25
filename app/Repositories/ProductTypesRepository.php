<?php

namespace App\Repositories;

use App\Models\ProductType;

use App\Interfaces\ProductTypeInterface;

class ProductTypesRepository implements ProductTypeInterface
{
    function getProductTypeById($id)
    {
        return ProductType::where('id', $id)->first();
    }
    // ----- get products
    function getProductType($request)
    {
        return ProductType::get();
    }
    
    // ----- insert products
    function insertProductType($request)
    {
        //-- insert products
        $ProductType = ProductType::create([
            "name" => $request->name
        ]);

        return $ProductType;
    }

    // ----- update products
    function updateProductType($request)
    {
        //-- update products
        return ProductType::where('id', $request->id)->update([
            "name" => $request->name
        ]);
    }
    

    // ----- delete products
    function deleteProductType($request)
    {
        return ProductType::where('id', $request->id)->delete();
    }
//

}
