<?php

namespace App\Interfaces;

interface CompanyRequestInterface
{
    function insertCompanyRequest($request);
    function getPendingCompanyRequests($request);

    function changeRequestStatus($request);
}
