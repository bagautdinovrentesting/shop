<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $user = \Auth::user();

        if ($user->type !== 'admin')
            return redirect('/');

        return view('admin.index');
    }
}
