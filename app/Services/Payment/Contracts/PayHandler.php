<?php

namespace App\Services\Payment\Contracts;

use App\Order;
use Illuminate\Http\Request;

interface PayHandler
{
    public function initiatePay(Order $order);
    public function processPay(Request $request);
}
