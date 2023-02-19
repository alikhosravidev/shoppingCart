<?php

namespace App\Listeners;

use App\Contract\Listener;
use App\Facades\Cart;

class UpdateCartAfterEntityUpdated implements Listener
{
    public function handle($argument)
    {
        $id = Cart::generateRawId($argument->id, get_class($argument));
        if (! Cart::exists($id)) {
            return;
        }

        Cart::updatePrice($id, $argument->getFinalPrice());
    }
}