<?php

namespace App;

use Gloudemans\Shoppingcart\Cart as ShoppingCart;

class Cart extends ShoppingCart
{
    protected $session;

    protected $event;

    public function __construct()
    {
        $this->session = $this->getSession();
        $this->event = $this->getEvents();
        parent::__construct($this->session, $this->event);
    }

    public function getSession()
    {
        return app()->make('session');
    }

    public function getEvents()
    {
        return app()->make('events');
    }
}
