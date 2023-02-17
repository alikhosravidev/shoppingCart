<?php

namespace App\Entities;

use App\Contract\BaseEntity;

/**
 * @property-read int $id
 * @property string $name
 * @property json $products
 * @property int $price
 * @property int $discount
 */
class Unit extends BaseEntity
{
    protected string $table = 'units';
}