<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;

class CatalogController extends Controller
{
    public function index()
    {
        $sections = Section::all();

        return view('front.catalog', ['sections' => $sections]);
    }
}
