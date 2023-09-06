<?php

namespace App\Interfaces;

interface SectionInterface
{
    function getAllSections($request);
    function getSectionById($id);

    function insertSection($request);
    function updateSection($request);
    function swapSections($request);
    function deleteSection($request);
}
