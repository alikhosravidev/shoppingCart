<?php

namespace App\Cart;

use App\Contract\Cart\CartStore;
use App\Exceptions\CartExceptions;

class Cart
{
    protected array $items;

    protected CartStore $store;

    public function __construct()
    {
        $this->store = resolve(CartStore::class);
        $this->items = $this->store->getItems();
    }

    public function getItems()
    {
        return $this->items;
    }

    public function total()
    {
        $total = 0;

        if ($this->isEmpty()) {
            return $total;
        }

        foreach ($this->items as $item) {
            $total += $item->getPrice();
        }

        return $total;
    }

    public function isEmpty()
    {
        return empty($this->items);
    }

    public function add($entityId, $entityType, $name, $quantity, $price)
    {
        if (! is_numeric($quantity) || $quantity < 1) {
            CartExceptions::invalidQuantity();
        }

        if (! is_numeric($price) || $price < 0) {
            CartExceptions::invalidPrice();
        }

        $id = $this->generateRawId($entityId, $entityType);
        if ($this->exists($id)) {
            $item = $this->items[$id];
            $this->store->increment($item, $quantity);
        } else {
            $this->store->add([
                                  'id' => $id,
                                  'name' => $name,
                                  'entity_id' => $entityId,
                                  'entity_type' => $entityType,
                                  'quantity' => $quantity,
                                  'price' => $price,
                              ]);
        }
    }

    public function exists($id): bool
    {
        return isset($this->items[$id]);
    }

    public function remove($id)
    {
        return $this->store->delete($id);
    }

    public function count()
    {
    }

    public function getItem($id): CartItem
    {
        return new CartItem($this->items[$id]);
    }

    public function generateRawId($id, $type)
    {
        return md5($id.$type);
    }
}