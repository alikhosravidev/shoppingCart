<?php

if (! function_exists('dump')) {
    function dump($data)
    {
        var_dump($data);
    }
}

if (! function_exists('dd')) {
    function dd($data)
    {
        dump($data);
        die();
    }
}

if (! function_exists('app')) {
    function app($abstract = null)
    {
        if (is_null($abstract)) {
            return \App\Core\Container::getInstance()->get('app');
        }

        return \App\Core\Container::getInstance()->get($abstract);
    }
}

if (! function_exists('resolve')) {
    function resolve($abstract)
    {
        return app($abstract);
    }
}