<?php

namespace App\Interfaces;

interface CompanyInterface
{
    function getCompanies($request);
    function getCompanyById($id);
    function insertCompany($request);
    function updateCompany($request);
    function deleteCompany($request);
}
