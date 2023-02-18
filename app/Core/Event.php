<?php

namespace App\Core;

class Event
{
    private static array $events = [];

    public static function listen($name, $callback)
    {
        self::$events[$name][] = $callback;
    }

    public static function dispatch($name, $argument = null)
    {
        foreach (self::$events[$name] as $event => $callback) {
            if (is_callable($callback)) {
                if ($argument && is_array($argument)) {
                    call_user_func_array($callback, $argument);
                } elseif ($argument && ! is_array($argument)) {
                    call_user_func($callback, $argument);
                } else {
                    call_user_func($callback);
                }
            } elseif (class_exists($callback)) {
                (new $callback)->handle($argument);
            }
        }
    }
}