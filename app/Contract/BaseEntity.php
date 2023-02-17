<?php

namespace App\Contract;

use App\Core\DatabaseManager;

class BaseEntity
{
    protected array $data = [];

    public function __construct(protected DatabaseManager $database)
    {
        $this->data = $this->database->select($this->getTableName());
    }

    protected function getLastId(): int
    {
        $ids = array_keys($this->data);

        return end($ids);
    }

    protected function getNewId(): int
    {
        $lastId = $this->getLastId();

        return ++$lastId;
    }

    protected function store(array $data)
    {
        $data['id'] = $data['id'] ?? $this->getNewId();

        $this->database->store($this->getTableName(), $data);
    }

    protected function update(int $id, array $data)
    {
        $this->database->update($this->getTableName(), $id, $data);
    }

    protected function delete(int $id)
    {
        $this->database->delete($this->getTableName(), $id);
    }

    public function getTableName()
    {
        return $this->table;
    }
}