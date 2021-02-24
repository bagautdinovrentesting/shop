<?php

namespace App\Services\Payment;

use App\PayHandler;

class PayHandlerResolver
{
    private const NAMESPACE = 'App\\Services\\Payment\\';

    public function resolve(PayHandler $handler) : Contracts\PayHandler
    {
        $handlerClass = self::NAMESPACE . $handler->handler . 'Handler';

        if (!class_exists($handlerClass)) {
            throw new \Exception('Pay handler not found');
        }

        return new $handlerClass;
    }
}
