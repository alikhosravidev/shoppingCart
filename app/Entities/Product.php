<?php

namespace App\Entities;

use App\Contract\BaseEntity;
use App\Utilities\PriceCalculator;

/**
 * @property-read int $id
 * @property string $name
 * @property int $price
 * @property int $discount
 */
class Product extends BaseEntity
{
    protected string $table = 'products';
}