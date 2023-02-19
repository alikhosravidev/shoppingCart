<?php

namespace App\Listeners;

use App\Cart\Cart;
use App\Contract\Listener;

class UpdateCartAfterEntityUpdated implements Listener
{
    public function handle($argument)
    {
        $cart = new Cart;

        $id = $cart->generateRawId($argument->id, get_class($argument));
        if (! $cart->exists($id)) {
            return;
        }

        $cart->updatePrice($id, $argument->getFinalPrice());
    }
}