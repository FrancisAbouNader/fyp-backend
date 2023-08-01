<?php

namespace App\Interfaces;

interface CompanyInterface
{
    function getCompany($request);
    function insertCompany($request);
    function updateCompany($request);
    function deleteCompany($request);
}
