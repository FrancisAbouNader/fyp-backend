<?php

namespace App\Interfaces;

interface ItemInterface
{
    function getItems($request);
    function getItemById($id);
    function getProductItems($request);
    function insertItem($request);
    function updateItem($request);
    function deleteItem($request);
}
