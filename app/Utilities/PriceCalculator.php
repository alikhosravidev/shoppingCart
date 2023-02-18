<?php

namespace App\Utilities;

class PriceCalculator
{
    public static function discountCalculator($price, $discount): int
    {
        return ($price * $discount) / 100;
    }

    public static function getFinalPrice($price, $discount): int
    {
        $discountAmount = self::discountCalculator($price, $discount);

        return $price - $discountAmount;
    }
}