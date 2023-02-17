<?php

namespace App\Entities;

use App\Contract\BaseEntity;

/**
 * @property-read int $id
 * @property string $name
 */
class User extends BaseEntity
{
    protected string $table = 'users';
}