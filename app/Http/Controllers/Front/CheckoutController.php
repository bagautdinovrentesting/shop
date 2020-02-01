<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Cart;
use App\User;
use App\Product;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('front.checkout');
    }

    public function store(Request $request, Cart $cart)
    {
        $data = $request->validate([
            'customer_name' => 'required|max:255',
            'customer_phone' => 'required',
            'customer_email' => 'required|email',
            'customer_address' => 'required'
        ]);

        $data['customer_surname'] = $request->input('customer_surname');
        $data['total'] = floatval($cart->total(0, '.', ''));

        $user = $request->user();

        if (!$user)
        {
            $user = User::create([
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'password' => bcrypt('laravelknopka')
            ]);
        }

        $productIDs = array_column($cart->content()->all(), 'id');
        $products = Product::findOrFail($productIDs);

        $order = $user->orders()->create($data);
        $order->products()->saveMany($products);

        $cart->destroy();

        request()->session()->flash('success', 'Заказ успешно оформлен!');

        return redirect()->route('cart.index');
    }
}
