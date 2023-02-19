<?php

namespace App\Facades;

use App\Contract\BaseFacade;
use App\Entities\Product;
use App\Entities\Unit;

/**
 * Class Cart.
 *
 * @method static getItems()
 * @method static total()
 * @method static isEmpty()
 * @method static add($entityId, $entityType, $name, $quantity, $price)
 * @method static updatePrice($id, $price)
 * @method static find($id)
 * @method static exists($id)
 * @method static remove($id)
 * @method static count()
 * @method static generateRawId($id, $type)
 * @method static flash()
 *
 * @see \App\Cart\Cart
 */
class Cart extends BaseFacade
{
    public static array $entityMap = [
        'product' => Product::class,
        'unit' => Unit::class,
    ];

    protected static function getFacadeAccessor()
    {
        return \App\Cart\Cart::class;
    }
}