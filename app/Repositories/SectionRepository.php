<?php

namespace App\Repositories;

use App\Models\Section;
use App\Interfaces\SectionInterface;

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
        $first_section = Section::find($request->first_section_id);
        $second_section  =  Section::find($request->second_section_id);

        $first_section_order = $first_section->order;
        $second_section_order = $second_section->order;
        $first_section->order = $second_section_order;
        $second_section->order = $first_section_order;

        $first_section->save();
        $second_section->save();
    }

    // --- delete Section
    function deleteSection($request)
    {
        return Section::where('id', $request->id)->delete();
    }
//

}
