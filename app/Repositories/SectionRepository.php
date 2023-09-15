<?php

namespace App\Repositories;

use App\Models\Section;
use App\Interfaces\SectionInterface;
use Illuminate\Support\Facades\DB;

class SectionRepository implements SectionInterface
{

    function getSectionById($id)
    {
        return Section::where('id', $id)->with('company')->with('product')->first();
    }
    // ----- get all users
    function getAllSections($request)
    {
        $sections = Section::with('company')->with('product');

        if(isset($request->company_id))
        {
            $sections = $sections->where('company_id', $request->company_id);
        }

        return $sections->get();
    }


    // ----- insert Section
    function insertSection($request)
    {
        //-- create user
        $Section = Section::create([
            "company_id" => $request->company_id,
            "product_id" => $request->product_id,
            "name" => $request->name,
            "order" => $request->order
        ]);

        return $Section;
    }

    // ----- update Section
    function updateSection($request)
    {
        //-- update Section
        return Section::where('id', $request->id)->update([
            "company_id" => $request->company_id,
            "product_id" => $request->product_id,
            "name" => $request->name,
            "order" => $request->order
        ]);
    }
    
    // ----- swap Sections
    function swapSections($request)
    {
        $sales = DB::table('company_product_sales')->where('company_id', $request->company_id)->orderBy('quantity', 'DESC')->get();

        foreach($sales as $key => $sale)
        {
            Section::where('company_id', $request->company_id)->where('product_id', $sale->product_id)->update([
                "order" => $key
            ]);
        }
        
    }

    // --- delete Section
    function deleteSection($request)
    {
        return Section::where('id', $request->id)->delete();
    }
//

}
