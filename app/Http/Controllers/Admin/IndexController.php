<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use App\User;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $users = User::select('*')->get();

        $users = $users->reject(function ($user) {
            return $user->type !== 'admin';
        });

        return view('admin.index', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $product = new Product();

        $product->name = $request->name;

        $product->save();
    }

    public function remove(Product $product)
    {
        $product->delete();
    }
}
