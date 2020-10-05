<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\User;
use App\Product;
use App\Events\NewOrder;

class CheckoutController extends Controller
{
    public function index(Cart $cart)
    {
        if ($cart->count() <= 0)
            return redirect()->route('cart.index');

        return view('front.checkout');
    }

    public function store(Request $request, Cart $cart)
    {
        $data = $request->validate([
            'customer_name' => 'required|max:255',
            'customer_phone' => 'required|regex:/[78][0-9]{10}/',
            'customer_email' => 'required|email',
            'customer_address' => 'required',
            'privacy' => 'accepted'
        ]);

        unset($data['privacy']);

        $data['customer_surname'] = $request->input('customer_surname');
        $data['total'] = floatval($cart->total(0, '.', ''));

        $user = $request->user() ?? User::where('email', $data['customer_email'])->first();

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

        NewOrder::dispatch($order);

        $cart->destroy();

        request()->session()->flash('success', 'Заказ успешно оформлен!');

        return redirect()->route('cart.index');
    }
}
