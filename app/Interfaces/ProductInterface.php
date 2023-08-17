<?php

namespace App\Interfaces;

interface ProductInterface
{
    function getProducts($request);
    function insertProduct($request);
    function updateProduct($request);
    function deleteProduct($request);
}
