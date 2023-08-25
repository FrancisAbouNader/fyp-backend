<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\Company;
use App\Models\Product;
use App\Interfaces\ItemInterface;

class ItemRepository implements ItemInterface
{
    // ----- get items
    function getItems($request)
    {
        return Item::with('product')->get();
    }

    // ----- get item by id 
    function getItemById($id)
    {
        return Item::where('id', $id)->first();
    }
        

    // ----- get product items
    function getProductItems($request)
    {
        return Item::where('product_id', $request->productId)->with('product')->get();
    }
    
    // ----- insert item
    function insertItem($request)
    {
        //-- insert item
        $item = Item::create([
            "imei" => $request->imei,
            'product_id' => $request->productId,
            'name' => $request->name,
            'ownerable_id' => $request->companyId,
            'ownerable_type' => Company::class
        ]);

        return $item;
    }

    // ----- update item
    function updateItem($request)
    {
        //-- update item
        return Item::where('id', $request->id)->update([
            "imei" => $request->imei,
            'product_id' => $request->productId,
            'name' => $request->name,
            'ownerable_id' => $request->companyId,
            'ownerable_type' => Company::class
        ]);
    }
    

    // ----- delete item
    function deleteItem($request)
    {
        return Item::where('id', $request->id)->delete();
    }
//

}
