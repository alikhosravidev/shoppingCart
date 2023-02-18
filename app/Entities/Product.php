<?php

namespace App\Entities;

use App\Contract\BaseEntity;

/**
 * @property-read int $id
 * @property string $name
 * @property int $price
 * @property int $discount
 */
class Product extends BaseEntity
{
    protected string $table = 'products';

    public function getFinalPrice(): float|int
    {
        if ($this->discount == 0) {
            return $this->price;
        }

        $discountAmount = $this->getDiscountAmount();

        return $this->price - $discountAmount;
    }

    public function getDiscountAmount(): float|int
    {
        return floor(($this->price * $this->discount) / 100);
    }
}