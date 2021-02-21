<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\PropertyValue;
use App\Services\Section\SectionService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    private $service;

    public function __construct(SectionService $service)
    {
        $this->service = $service;
    }

    public function show(Section $section, Request $request)
    {
        $page = $request->has('page') ? $request->get('page') : 1;
        $viewData = $this->service->getViewData($section, $page);

        $viewData['checked'] = [];

        return view('front.section', $viewData);
    }

    public function filter(Section $section, Request $request)
    {
        $viewData = $filterProperties = [];
        $filterValues = $filterProps = [];

        foreach ($request->all() as $paramName => $paramValue) {
            if (Str::startsWith($paramName, 'p_')) {
                $propertyId = Str::substr($paramName, 2);
                $filterProperties[$propertyId] = explode(',', $paramValue);
                $filterProps[] = $propertyId;
                $filterValues = array_merge($filterValues, explode(',', $paramValue));
            }
        }

        $viewData['checked'] = $filterProperties;

        $page = $request->has('page') ? $request->get('page') : 1;

        if (!empty($filterProperties)) {
            $viewData = array_merge($viewData, $this->service->getViewDataByFilter($section, $filterProps, $filterValues, $page));
            $viewData['products'] = $viewData['products']->appends($request->except('page', 'ajax'));
        } else {
            $viewData = array_merge($viewData, $this->service->getViewData($section, $page));
        }

        $viewName = $request->has('ajax') ? 'front.section_content' : 'front.section';

        return view($viewName, $viewData);
    }
}
