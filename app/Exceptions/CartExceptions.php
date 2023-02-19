<?php

namespace App\Exceptions;

use Exception;

class CartExceptions extends Exception
{
    const INVALID_PRICE = 'Invalid price';
    const INVALID_QUANTITY = 'Invalid quantity';

    public static function invalidPrice()
    {
        throw new self(self::INVALID_PRICE);
    }

    public static function invalidQuantity()
    {
        throw new self(self::INVALID_QUANTITY);
    }
}