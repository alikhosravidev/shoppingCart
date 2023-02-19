<?php

namespace App\Cart;

use App\Contract\Cart\CartStore;
use App\Core\DatabaseManager;

class JsonCart implements CartStore
{
    protected string $table = 'cart';

    protected DatabaseManager $database;

    public function __construct()
    {
        $this->database = resolve(DatabaseManager::class);
    }

    public function getItems()
    {
        return $this->database->select($this->table) ?? [];
    }

    public function add(array $data)
    {
        $this->database->create($this->table, $data);
    }

    public function increment($item, $quantity): bool
    {
        $id = $item['id'];
        $item['quantity'] = $item['quantity'] + $quantity;

        return $this->update($id, $item);
    }

    public function decrement($item, $quantity): bool
    {
        $id = $item['id'];
        $item['quantity'] = $item['quantity'] - $quantity;
        if ($item['quantity'] < 0) {
            $item['quantity'] == 0;
        }

        return $this->update($id, $item);
    }

    public function delete($id): bool
    {
        return $this->database->delete($this->table, $id);
    }

    public function update($id, array $data): bool
    {
        $data['id'] = $id;

        return $this->database->update($this->table, $id, $data);
    }

    public function flash()
    {
        $this->database->flash($this->table);
    }
}