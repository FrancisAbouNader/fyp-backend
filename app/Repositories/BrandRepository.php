<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Interfaces\BrandInterface;

class BrandRepository implements BrandInterface
{
    // ----- get brands
    function getBrands($request)
    {
        return Brand::get();
    }
    
    // ----- insert brand
    function insertBrand($request)
    {
        //-- insert brand
        $brand = Brand::create([
            "name" => $request->name
        ]);

        return $brand;
    }

    // ----- update brand
    function updateBrand($request)
    {
        //-- update brand
        return Brand::where('id', $request->id)->update([
            "name" => $request->name
        ]);
    }
    

    // ----- delete brand
    function deletebrand($request)
    {
        return Brand::where('id', $request->id)->delete();
    }
//

}
