<?php

namespace App\Contract;

use App\Core\DatabaseManager;

class BaseEntity
{
    protected DatabaseManager $database;

    public function __construct()
    {
        $this->database = resolve(DatabaseManager::class);
    }

    protected function getLastId(): int
    {
        return count($this->all());
    }

    public function getNewId(): int
    {
        $lastId = $this->getLastId();

        return ++$lastId;
    }

    public static function query()
    {
        return (new static);
    }

    public function all(): array
    {
        return $this->database->select($this->getTableName()) ?? [];
    }

    public function find($id): ?array
    {
        return $this->database->select($this->getTableName(), $id);
    }

    public function create(array $data)
    {
        $data['id'] = $this->getNewId();

        $this->database->create($this->getTableName(), $data);
    }

    public function update($id, array $data)
    {
        $data['id'] = $id;

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