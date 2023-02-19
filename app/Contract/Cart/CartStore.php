<?php

namespace App\Contract\Cart;

interface CartStore
{
    public function getItems();

    public function add(array $data);

    public function increment($item, $quantity): bool;

    public function decrement($item, $quantity): bool;

    public function update($id, array $data): bool;

    public function delete($id): bool;

    public function flash();
}