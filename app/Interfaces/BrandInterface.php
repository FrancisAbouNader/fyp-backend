<?php

namespace App\Interfaces;

interface BrandInterface
{
    function getBrands($request);
    function insertBrand($request);
    function updateBrand($request);
    function deleteBrand($request);
}
