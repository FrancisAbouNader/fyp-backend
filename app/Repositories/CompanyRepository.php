<?php

namespace App\Repositories;



use App\Interfaces\CompanyInterface;
use App\Models\Company;

class CompanyRepository implements CompanyInterface
{
    // ----- get Companies
    function getCompanies($request)
    {
        return Company::get();
    }

    
    // ----- get Company by id 
    function getCompanyById($id)
    {
        return Company::where('id', $id)->first();
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
