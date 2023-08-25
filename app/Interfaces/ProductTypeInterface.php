<?php

namespace App\Interfaces;

interface ProductTypeInterface
{
    function getProductType($request);
    function getProductTypeById($id);
    function insertProductType($request);
    function updateProductType($request);
    function deleteProductType($request);
}
