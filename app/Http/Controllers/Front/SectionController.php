<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Section\Contracts\SectionService;
use App\Services\Section\RelationService;
use Illuminate\Http\Request;
use App\Section;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    private SectionService $service;

    private const PER_PAGE = 24;

    public function __construct(SectionService $service)
    {
        $this->service = $service;
    }

    public function show(Section $section, Request $request)
    {
        $page = $request->has('page') ? $request->get('page') : 1;

        $viewData = $this->service->getViewData($section, self::PER_PAGE, $page);

        return view('front.section', $viewData);
    }

    public function filter(Section $section, Request $request)
    {
        $page = $request->has('page') ? $request->get('page') : 1;

        $viewData = $this->service->getViewDataWithFilter($section, self::PER_PAGE, $page, $request);

        $viewName = $request->has('ajax') ? 'front.section_content' : 'front.section';

        return view($viewName, $viewData);
    }
}
