<?php

namespace App\Core;

class Config
{
    public function __construct(protected array $config = [])
    {
        $timezone = $this->config['timezone'] ?? 'Asia/Tehran';
        date_default_timezone_set($timezone);
    }

    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }

    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->config;
        }
        $key = is_array($key) ? $key : explode('.', $key);
        $target = $this->config;

        while (! is_null($segment = array_shift($key))) {
            if (is_array($target) && array_key_exists($segment, $target)) {
                $target = $target[$segment];
            } else {
                return $default;
            }
        }

        return $target;
    }
}