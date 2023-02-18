<?php

namespace App\Contract;

use App\Core\Container;
use App\Core\DatabaseManager;

class BaseEntity
{
    public function __construct(protected DatabaseManager $database, protected Container $container)
    {
    }

    protected function getLastId(): int
    {
        return count($this->all());
    }

    public function all(): array
    {
        return $this->database->select($this->getTableName()) ?? [];
    }

    public function find($id): ?array
    {
        return $this->database->select($this->getTableName(), $id);
    }

    public function store(array $data)
    {
        $this->database->store($this->getTableName(), $data);
    }

    public function update(int $id, array $data)
    {
        $this->database->update($this->getTableName(), $id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->database->delete($this->getTableName(), $id);
    }

    public function getTableName(): string
    {
        return $this->table;
    }
}