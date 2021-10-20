<?php

namespace App\Services\Section\Contracts;

use App\Section;
use Illuminate\Http\Request;

interface SectionService
{
    public function getViewData(Section $section, int $perPage, int $currentPage) : array;
    public function getViewDataWithFilter(Section $section, int $perPage, int $currentPage, Request $request) : array;
}
