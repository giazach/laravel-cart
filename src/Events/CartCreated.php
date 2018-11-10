<?php

namespace Berkayk\LaravelCart\Events;

class CartCreated
{
    /** @var array */
    public $cartData;

    public function __construct($cartData)
    {
        $this->cartData = $cartData;
    }
}
