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

    public function create($name, $price, $discount)
    {
        if ($price < 0) {

        }
    }
}