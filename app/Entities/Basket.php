<?php

namespace App\Entities;

use App\Contract\BaseEntity;

/**
 * @property-read int $id
 * @property int $user_id
 * @property int $entity_id
 * @property string $entity_type
 */
class Basket extends BaseEntity
{
    protected string $table = 'basket';

    public function entity()
    {

    }
}