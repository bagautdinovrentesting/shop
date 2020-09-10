<?php

namespace App\Listeners;

use App\Events\NewOrder;
use App\Mail\NewOrder as OrderMailer;
use Illuminate\Support\Facades\Mail;

class SendNewOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewOrder  $event
     * @return void
     */
    public function handle(NewOrder $event)
    {
        Mail::to($event->order->customer_email)->send(new OrderMailer($event->order));
    }
}
