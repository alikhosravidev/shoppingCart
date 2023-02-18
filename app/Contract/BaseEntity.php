<?php

namespace App\Contract;

use App\Core\DatabaseManager;

class BaseEntity
{
    public function __construct(protected DatabaseManager $database)
    {
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
        return resolve(static::class);
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
        $data['id'] = $this->getNewId();

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