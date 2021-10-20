<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderStatus;
use App\PayHandler;
use App\Services\Payment\PayHandlerResolver;
use Illuminate\Http\Request;
use App\Cart;
use App\User;
use App\Product;
use App\Events\NewOrder;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private PayHandlerResolver $resolver;

    public function __construct(PayHandlerResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function index(Cart $cart)
    {
        if ($cart->count() <= 0)
            return redirect()->route('cart.index');

        $payHandlers = PayHandler::active()->get();

        return view('front.checkout', compact('payHandlers'));
    }

    public function store(OrderRequest $request, Cart $cart)
    {
        $data = collect($request->validated())->except(['privacy', 'pay_handler']);

        $data->put('total', floatval($cart->total(0, '.', '')));
        $data->put('status_id', OrderStatus::getCreateStatusId());

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

        $order = DB::transaction(function () use ($user, $data, $products) {
            $order = $user->orders()->create($data->toArray());
            $order->products()->saveMany($products);

            return $order;
        });

        $cart->destroy();

        $payHandlerId = $request->get('pay_handler');

        $dbPayHandler = PayHandler::findOrFail($payHandlerId);
        $payHandler = $this->resolver->resolve($dbPayHandler);
        $payHandler->initiatePay($order);

        NewOrder::dispatch($order);



        request()->session()->flash('success', 'Заказ успешно оформлен!');

        return redirect()->route('cart.index');
    }
}
