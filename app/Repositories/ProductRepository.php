<?php

namespace App\Repositories;

use App\Models\Product;

use App\Interfaces\ProductInterface;

class ProductRepository implements ProductInterface
{
    function getProductById($request)
    {
        $product =  Product::where('id', $request->Id);

        if(isset($request->company_id))
            $product = $product->with(['sections' => function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            }]);
        else
            $product = $product->with('sections');

        return $product->first();

    }
    // ----- get products
    function getProducts($request)
    {
        $products =  Product::with('brand')->with('productType');
        if(isset($request->company_id))
            $products = $products->with(['sections' => function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            }]);
        else
            $products = $products->with('sections');

        if(isset($request->ProductName))
            $products = $products->where("name", 'ILIKE', '%' . $request->ProductName . '%');
        
        if(isset($request->BrandId))
            $products = $products->where("brand_id", $request->BrandId );
        
        if(isset($request->ProductTypeId))
            $products = $products->where("product_type_id",$request->ProductTypeId );

        return $products->get();
    }
    
    // ----- insert products
    function insertProduct($request)
    {
        //-- insert products
        $ProductType = Product::create([
            "name" => $request->name,
            'model_number' => $request->model_number,
            'package_height' => $request->package_height,
            'package_width' => $request->package_width,
            'package_length' => $request->package_length,
            'package_weight' => $request->package_weight,
            'product_height'=> $request->product_height,
            'product_width' => $request->product_width,
            'product_length' => $request->product_length,
            'product_weight' => $request->product_weight,
            'description' => $request->description,
            "brand_id" => $request->brand_id,
            "product_type_id" => $request->product_type_id,
        ]);

        return $ProductType;
    }

    // ----- update products
    function updateProduct($request)
    {
        //-- update products
        return Product::where('id', $request->id)->update([
            "name" => $request->name,
            'model_number' => $request->model_number,
            'package_height' => $request->package_height,
            'package_width' => $request->package_width,
            'package_length' => $request->package_length,
            'package_weight' => $request->package_weight,
            'product_height'=> $request->product_height,
            'product_width' => $request->product_width,
            'product_length' => $request->product_length,
            'product_weight' => $request->product_weight,
            'description' => $request->description,
            "brand_id" => $request->brand_id,
            "product_type_id" => $request->product_type_id,
        ]);
    }
    

    // ----- delete products
    function deleteProduct($request)
    {
        return Product::where('id', $request->id)->delete();
    }
//

}
