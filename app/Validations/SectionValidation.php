<?php

namespace App\Validations;

use App\Models\Section;
use Illuminate\Support\Facades\Validator;

class SectionValidation
{
    function idValidation()
    {
        return Validator::make(request()->all(), [
            "Id" => "required|integer"
        ]);
    }
    
    function validateInsertSection()
    {
        return Validator::make(request()->all(), [
            "name" => "required|string",
            "product_id" => "required|integer|exists:products,id",
            "company_id" => "required|integer|exists:companies,id",
            "order" => "required|integer"
        ]);
    }


    function validateUpdateSection()
    {
        return Validator::make(request()->all(), [
            "id" => "required|integer|exists:sections,id",
            "name" => "required|string",
            "product_id" => "required|integer|exists:products,id",
            "company_id" => "required|integer|exists:companies,id",
            "order" => "required|integer"

        ]);
    }

    function validateSwapSections()
    {
        return Validator::make(request()->all(), [
            "company_id" => "required|integer|exists:companies,id",
        ]);
    }

    function validateDeleteSection()
    {
        return Validator::make(request()->all(), [
            "id"    => "required|exists:sections,id",
        ]);
    }

    function validateGetSections()
    {
        return Validator::make(request()->all(), [
            "company_id"    => "nullable|integer|exists:companies,id",
        ]);
    }
}
