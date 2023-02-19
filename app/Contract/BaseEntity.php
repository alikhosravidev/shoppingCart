<?php

namespace App\Contract;

use App\Core\DatabaseManager;

class BaseEntity
{
    protected DatabaseManager $database;

    protected ?array $properties;

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
        $data = $this->database->select($this->getTableName()) ?? [];
        if (empty($data)) {
            return [];
        }
        $items = [];
        foreach ($data as $item) {
            $obj = (new static);
            $obj->setProperties($item);
            $items[] = $obj;
        }

        return $items;
    }

    public function find($id): static
    {
        $this->setProperties($this->database->select($this->getTableName(), $id));

        return $this;
    }

    public function exists(): bool
    {
        return (bool) $this->properties;
    }

    public function create(array $data): static
    {
        $data['id'] = $this->getNewId();
        $this->database->create($this->getTableName(), $data);
        $this->setProperties($data);

        return $this;
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

    public function setProperties($data)
    {
        $this->properties = $data;
    }

    public function __get(string $name)
    {
        return $this->properties[$name] ?? null;
    }
}