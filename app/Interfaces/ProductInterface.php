<?php

namespace App\Interfaces;

interface ProductInterface
{
    function getProductById($id);
    function getProducts($request);
    function insertProduct($request);
    function updateProduct($request);
    function deleteProduct($request);
}
