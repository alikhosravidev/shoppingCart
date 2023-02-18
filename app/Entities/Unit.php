<?php

namespace App\Entities;

use App\Contract\BaseEntity;

/**
 * @property-read int $id
 * @property string $name
 * @property array $products
 * @property int $price
 * @property int $discount
 */
class Unit extends BaseEntity
{
    protected string $table = 'units';

    public function getProduts($unitId)
    {
        $unit = $this->find($unitId);
        $products = [];
        foreach ($unit['products'] as $id) {
            $products[$id] = Product::query()->find($id);
        }

        return $products;
    }

    public function getPrice($unitId)
    {
        $unit = $this->find($unitId);

        if (isset($unit['price'])) {
            return $unit['price'];
        }

        $unitPrice = 0;
        $products = $this->getProduts($unitId);
        foreach ($products as $id => $product) {
            $price = $product['price'];
            if ($product['discount'] != 0) {
                $price = self::getFinalPrice($price, $product['discount']);
            }
            $unitPrice += $price;
        }

        return $unitPrice;
    }

    public function getPriceWithoutDiscount($unitId)
    {
        $unitPrice = 0;
        $products = $this->getProduts($unitId);
        foreach ($products as $id => $product) {
            $unitPrice += $product['price'];
        }

        return $unitPrice;
    }

    public function getDiscount($unitId)
    {
        $unit = $this->find($unitId);

        if (isset($unit['discount'])) {
            return $unit['discount'];
        }

        $unitPrice = $this->getPrice($unitId);
        $unitPriceWithoutDiscount = $this->getPriceWithoutDiscount($unitId);
        $discountAmount = $unitPriceWithoutDiscount - $unitPrice;
        if ($discountAmount == 0) {
            return 0;
        }

        return floor(($discountAmount * 100) / $unitPriceWithoutDiscount);
    }

    public function getAllUnitProductIds()
    {
        $productIds = [];
        foreach ($this->all() as $unit) {
            $productIds = array_merge($productIds, $unit['products']);
        }

        return $productIds;
    }

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