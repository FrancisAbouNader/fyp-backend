<?php

namespace App\Interfaces;

interface ProductTypeInterface
{
    function getProductType($request);
    function insertProductType($request);
    function updateProductType($request);
    function deleteProductType($request);
}
