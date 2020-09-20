<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;

class SectionController extends Controller
{
    public function show(Section $section)
    {
        $products = $section->products()->where('status', 1)->paginate(4);

        return view('front.section', ['section' => $section, 'products' => $products]);
    }
}
