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
        $items =  Item::with('product');
        
        if(isset($request->ProductIds))
        {
            $items = $items->whereIn('product_id', $request->ProductIds);
        }

        if(isset($request->CompanyId))
        {
            $items = $items->where('ownerable_id', $request->CompanyId)->where('ownerable_type', Company::class);
        }

        if(isset($request->IsSold))
        {
            $items = $items->where('is_sold', $request->IsSold);
        }
        
        return $items->get();
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
            'product_id' => $request->product_id,
            'name' => $request->name,
            'ownerable_id' => $request->company_id,
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
            'product_id' => $request->product_id,
            'name' => $request->name,
            'ownerable_id' => $request->company_id,
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
