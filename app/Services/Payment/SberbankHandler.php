<?php

namespace App\Services\Payment;

use App\Order;
use App\Services\Payment\Contracts\PayHandler;
use App\Services\Payment\Exceptions\PaymentException;
use Illuminate\Http\Request;
use Voronkovich\SberbankAcquiring\Client;

class SberbankHandler implements PayHandler
{
    protected const SUCCESS_STATUS = 1;

    public function initiatePay(Order $order)
    {
        $config = config('payments.sberbank');

        $client = new Client([
            'userName' => $config['username'],
            'password' => $config['password'],
        ]);

        try {
            $result = $client->registerOrder($order->id, $order->total, $config['return_url'], ['failUrl' => $config['fail_url']]);
        } catch (\Exception $e) {
            throw new PaymentException($e->getMessage());
        }

        header('Location: ' . $result['formUrl']);
    }

    public function processPay(Request $request)
    {
        /** @var Order $order*/
        $order = Order::findOrFail($request->get('orderNumber'));

        if ($request->get('status') === self::SUCCESS_STATUS)
            $order->setPayedStatus();
    }
}
