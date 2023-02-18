<?php

namespace App\Exceptions;

use App\Contract\Exceptions\BusinessException;

class UnitExceptions extends BusinessException
{
    const INVALID_PRICE = 'The unit price should not be a negative number.';
    const INVALID_DISCOUNT = 'The amount of unit discount should not be a negative value.';
    const INVALID_NAME = 'Unit title cannot be an empty value.';
    const INVALID_PRODUCTS = 'The unit must contain two or more products';

    public static function invalidPrice()
    {
        throw new self(self::INVALID_PRICE);
    }

    public static function invalidDiscount()
    {
        throw new self(self::INVALID_DISCOUNT);
    }

    public static function invalidName()
    {
        throw new self(self::INVALID_NAME);
    }

    public static function invalidProducts()
    {
        throw new self(self::INVALID_PRODUCTS);
    }
}