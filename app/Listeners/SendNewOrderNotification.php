<?php

namespace App\Listeners;

use App\Events\NewOrder;
use App\User;
use App\Notifications\NewOrder as NewOrderNotify;
use Notification;

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
     *
     * @param  User  $user
     *
     * @return void
     */
    public function handle(NewOrder $event)
    {
        //Mail::to($event->order->customer_email)->send(new OrderMailer($event->order));
        Notification::route('mail', $event->order->customer_email)->notify(new NewOrderNotify($event->order));
    }
}
