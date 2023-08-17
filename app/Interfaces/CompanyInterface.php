<?php

namespace App\Interfaces;

interface CompanyInterface
{
    function getCompanies($request);
    function insertCompany($request);
    function updateCompany($request);
    function deleteCompany($request);
}
