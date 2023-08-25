<?php

namespace App\Repositories;

use App\Models\Product;

use App\Interfaces\ProductInterface;

class ProductRepository implements ProductInterface
{
    // ----- get products
    function getProducts($request)
    {
        return Product::with('brand')->with('productType')->get();
    }
    
    // ----- insert products
    function insertProduct($request)
    {
        //-- insert products
        $ProductType = Product::create([
            "name" => $request->productName,
            'model_number' => $request->modelNumber,
            'package_height' => $request->packageHeight,
            'package_width' => $request->packageWidth,
            'package_length' => $request->packageLength,
            'package_weight' => $request->packageWeight,
            'product_height'=> $request->productHeight,
            'product_width' => $request->productWidth,
            'product_length' => $request->productLength,
            'product_weight' => $request->productWeight,
            'description' => $request->description,
            "brand_id" => $request->brandId,
            "product_type_id" => $request->productTypeId,
        ]);

        return $ProductType;
    }

    // ----- update products
    function updateProduct($request)
    {
        //-- update products
        return Product::where('id', $request->id)->update([
            "name" => $request->productName,
            'model_number' => $request->modelNumber,
            'package_height' => $request->packageHeight,
            'package_width' => $request->packageWidth,
            'package_length' => $request->packageLength,
            'package_weight' => $request->packageWeight,
            'product_height'=> $request->productHeight,
            'product_width' => $request->productWidth,
            'product_length' => $request->productLength,
            'product_weight' => $request->productWeight,
            'description' => $request->description,
            "brand_id" => $request->brandId,
            "product_type_id" => $request->productTypeId,
        ]);
    }
    

    // ----- delete products
    function deleteProduct($request)
    {
        return Product::where('id', $request->id)->delete();
    }
//

}
