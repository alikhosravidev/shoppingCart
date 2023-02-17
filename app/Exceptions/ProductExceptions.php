<?php

namespace App\Exceptions;

use App\Contract\Exceptions\BusinessException;

class ProductExceptions extends BusinessException
{
    const INVALID_PRICE = 'قیمت محصول نباید یک عدد منفی باشد.';
    const INVALID_DISCOUNT = 'میزان تخفیف محصول نباید یک مقدار منفی باشد.';
    const INVALID_TITLE = 'عنوان محصول نمی تواند یک مقدار خالی باشد.';

    public static function invalidPrice()
    {
        return new self(self::INVALID_PRICE);
    }

    public static function invalidDiscount()
    {
        return new self(self::INVALID_DISCOUNT);
    }

    public static function invalidTitle()
    {
        return new self(self::INVALID_TITLE);
    }
}