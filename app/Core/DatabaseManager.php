<?php

namespace App\Core;

class DatabaseManager
{
    protected array $data = [];

    protected string $databasePath;

    public function __construct(Config $config)
    {
        $this->databasePath = $config->get('database.path');
        $this->data = json_decode(file_get_contents($this->databasePath), true) ?? [];
    }

    public function select($table, $id = null)
    {
        $tableData = $this->data[$table] ?? null;
        if (! $tableData) {
            return null;
        }

        if (! $id) {
            return $tableData;
        }

        return $tableData[$id] ?? null;
    }

    public function store($table, $data)
    {
        $this->data[$table][] = $data;
        $this->put();
    }

    public function update($table, $id, $data)
    {
        if (! isset($this->data[$table][$id])) {
            return $this->store($table, $data);
        }

        $this->data[$table][$id] = $data;
        $this->put();
    }

    public function delete($table, $id)
    {
        // real id is: n - 1
        --$id;

        if (! isset($this->data[$table][$id])) {
            return false;
        }

        unset($this->data[$table][$id]);
        $this->put();

        return true;
    }

    public function getData()
    {
        return $this->data;
    }

    public function flash()
    {
        $this->data = [];
        $this->put();
    }

    public function put()
    {
        file_put_contents($this->databasePath, json_encode($this->data));
    }
}