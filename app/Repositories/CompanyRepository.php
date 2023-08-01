<?php

namespace App\Repositories;



use App\Interfaces\CompanyInterface;
use App\Models\Company;

class CompanyRepository implements CompanyInterface
{
    // ----- get Company
    function getCompany($request)
    {
        return Company::get();
    }
    
    // ----- insert Company
    function insertCompany($request)
    {
        //-- insert Company
        $Company = Company::create([
            "name" => $request->companyLegalName,
            "location" => $request->location
        ]);

        return $Company;
    }

    // ----- update Company
    function updateCompany($request)
    {
        //-- update Company
        return Company::where('id', $request->id)->update([
            "name" => $request->name,
            "location" => $request->location
        ]);
    }
    

    // ----- delete Company
    function deleteCompany($request)
    {
        return Company::where('id', $request->id)->delete();
    }
//

}
