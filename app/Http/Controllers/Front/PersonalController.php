<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Review;
use App\Order;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index(Request $request)
    {
        return view('front.personal.index', ['user' => $request->user()]);
    }

    public function orders(Request $request)
    {
        $orders = Order::with('user', 'status')->where('user_id', $request->user()->id)->get();

        return view('front.personal.orders.list', ['user' => $request->user(), 'orders' => $orders]);
    }

    public function reviews(Request $request)
    {
        $reviews = Review::with('user', 'product')->where('user_id', $request->user()->id)->get();

        return view('front.personal.reviews.list', ['user' => $request->user(), 'reviews' => $reviews]);
    }
}
