<?php

namespace App\Exceptions;

use App\Contract\Exceptions\BusinessException;

class ProductExceptions extends BusinessException
{
    const INVALID_PRICE = 'The product price should not be a negative number.';
    const INVALID_DISCOUNT = 'The amount of product discount should not be a negative value.';
    const INVALID_NAME = 'Product title cannot be an empty value.';

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
}