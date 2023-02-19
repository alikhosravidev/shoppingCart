<?php

namespace App\Cart;

use App\Contract\BaseEntity;

class CartItem
{
    public string $id;

    public string $name;

    public string $entity_type;

    public int $entity_id;

    public int $quantity;

    public int $price;

    public function __construct(array $properties)
    {
        $this->id = $properties['id'];
        $this->name = $properties['name'];
        $this->entity_id = $properties['entity_id'];
        $this->entity_type = $properties['entity_type'];
        $this->quantity = $properties['quantity'];
        $this->price = $properties['price'];
    }

    public function increment()
    {
        ++$this->quantity;

        return $this;
    }

    public function decrement()
    {
        --$this->quantity;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price * $this->quantity;
    }

    public function getEntity(): BaseEntity
    {
        return $this->entity_type::query()->find($this->entity_id);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'entity_id' => $this->entity_id,
            'entity_type' => $this->entity_type,
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }

    public function __get(string $name)
    {
        return $this->properties[$name] ?? null;
    }
}