<?php

namespace App\Entities;

use App\Contract\BaseEntity;
use App\Utilities\PriceCalculator;

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

    public static function getAllUnitProductIds(): array
    {
        $productIds = [];
        foreach (static::query()->all() as $unit) {
            $productIds = array_merge($productIds, $unit->products);
        }

        return $productIds;
    }

    public function getProduts()
    {
        $products = [];
        foreach ($this->products as $id) {
            $products[$id] = Product::query()->find($id);
        }

        return $products;
    }

    public function getTotalProductPrice()
    {
        $total = 0;
        $products = $this->getProduts();
        foreach ($products as $product) {
            $total += $product->price;
        }

        return $total;
    }

    public function getTotalProductFinalPrice()
    {
        $total = 0;
        $products = $this->getProduts();
        foreach ($products as $product) {
            $total += $product->getFinalPrice();
        }

        return $total;
    }

    public function getPrice()
    {
        if ($this->price) {
            return $this->price;
        }

        return $this->getTotalProductPrice();
    }

    public function getFinalPrice(): float|int
    {
        if ($this->discount && $this->price) {
            $discountAmount = floor(($this->price * $this->discount) / 100);

            return $this->price - $discountAmount;
        }

        if ($this->discount) {
            $price = $this->getTotalProductPrice();
            $discountAmount = floor(($price * $this->discount) / 100);

            return $price - $discountAmount;
        }

        if ($this->price) {
            return $this->price;
        }

        return $this->getTotalProductFinalPrice();
    }

    public function getDiscount()
    {
        if ($this->discount && $this->price) {
            return $this->discount;
        }

        if ($this->discount) {
            return $this->discount;
        }

        if ($this->price) {
            return 0;
        }

        $price = $this->getPrice();
        $finalPrice = $this->getFinalPrice();
        $discountAmount = $price - $finalPrice;

        return ($discountAmount * 100) / $price;
    }
}