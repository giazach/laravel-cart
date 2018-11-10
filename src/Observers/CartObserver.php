<?php

namespace Berkayk\LaravelCart\Observers;

use Berkayk\LaravelCart\Models\Cart;

class CartObserver
{
    /**
     * Listen to the Cart deleting event.
     *
     * @param \Berkayk\LaravelCart\Models\Cart $cart
     * @return void
     */
    public function deleting(Cart $cart)
    {
        $cart->items()->delete();
    }
}
