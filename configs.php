<?php

return [

    'database' => [
        'path' => __DIR__.'/database.json',
    ],

    'commands' => [
        // products
        \App\Commands\Product\ListProduct::class,
        \App\Commands\Product\CreateProduct::class,
        \App\Commands\Product\DeleteProduct::class,
        \App\Commands\Product\UpdateProduct::class,

        // units
        \App\Commands\Unit\ListUnit::class,
        \App\Commands\Unit\CreateUnit::class,
        \App\Commands\Unit\DeleteUnit::class,
        \App\Commands\Unit\UpdateUnit::class,
    ],

];