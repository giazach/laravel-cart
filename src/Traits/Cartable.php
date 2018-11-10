<?php

namespace Berkayk\LaravelCart\Traits;

use Berkayk\LaravelCart\Core\Cart;

trait Cartable
{
    /**
     * Adds an item to the cart.
     *
     * @param int Identifier
     * @param int quantity
     * @return
     */
    public static function addToCart($id, $quantity = 1)
    {
        $class = static::class;

        return app(Cart::class)->add($class::findOrFail($id), $quantity);
    }
}
