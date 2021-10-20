<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use App\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private Cart $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        return view('front.cart', ['cartItems' => $this->cart->content(), 'total' => $this->cart->total()]);
    }

    public function store(Request $request): JsonResponse
    {
        $product = Product::findOrFail($request->input('product'));

        $this->cart->add($product, 1, []);

        return response()->json(['count' => $this->cart->count()]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id): RedirectResponse
    {
        $this->cart->remove($id);
        request()->session()->flash('success', __('cart.destroy_product_message'));

        return redirect()->route('cart.index');
    }
}
