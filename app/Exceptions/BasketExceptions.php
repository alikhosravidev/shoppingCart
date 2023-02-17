<?php

namespace App\Exceptions;

use App\Contract\Exceptions\BusinessException;

class BasketExceptions extends BusinessException
{
    const INVALID_COUNT = 'حداقل یک آیتم باید در سبد خرید وجود داشته باشید.';

    public static function invalidCount()
    {
        return new self(self::INVALID_COUNT);
    }
}