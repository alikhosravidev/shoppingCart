<?php

namespace App\Contract;

use App\Core\DatabaseManager;

class BaseEntity
{
    protected array $data = [];

    public function __construct(protected DatabaseManager $database)
    {
        $this->data = $this->database->select($this->getTableName()) ?? [];
    }

    protected function getLastId(): int
    {
        return count($this->data);
    }

    protected function getNewId(): int
    {
        $lastId = $this->getLastId();

        return ++$lastId;
    }

    public function all(): array
    {
        return $this->data;
    }

    public function store(array $data)
    {
        $data['id'] = $data['id'] ?? $this->getNewId();

        $this->database->store($this->getTableName(), $data);
    }

    public function update(int $id, array $data)
    {
        $this->database->update($this->getTableName(), $id, $data);
    }

    public function delete(int $id)
    {
        return $this->database->delete($this->getTableName(), $id);
    }

    public function getTableName()
    {
        return $this->table;
    }
}