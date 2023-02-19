<?php

return [

    'database' => [
        'path' => __DIR__.'/database.json',
    ],

    'cart' => [
        'storage' => \App\Cart\JsonCart::class
    ],

    'commands' => [
        // Products
        \App\Commands\Product\ListProduct::class,
        \App\Commands\Product\CreateProduct::class,
        \App\Commands\Product\DeleteProduct::class,
        \App\Commands\Product\UpdateProduct::class,

        // Units
        \App\Commands\Unit\ListUnit::class,
        \App\Commands\Unit\CreateUnit::class,
        \App\Commands\Unit\DeleteUnit::class,
        \App\Commands\Unit\UpdateUnit::class,

        // Cart
        \App\Commands\Cart\AddToCart::class,
        \App\Commands\Cart\DeleteFromCart::class,
    ],

];