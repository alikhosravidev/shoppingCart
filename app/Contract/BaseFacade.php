<?php

namespace App\Contract;

abstract class BaseFacade
{
    protected static $instance;

    abstract protected static function getFacadeAccessor();

    protected static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = resolve(static::getFacadeAccessor());
        }

        return static::$instance;
    }

    public static function __callStatic(string $name, array $arguments)
    {
        return static::getInstance()->$name(...$arguments);
    }
}