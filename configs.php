<?php

return [

    'database' => [
        'path' => __DIR__.'/database.json',
    ],

    'commands' => [
        // products
        \App\Commands\Product\ProductList::class,
        \App\Commands\Product\ProductAdd::class,
        \App\Commands\Product\ProductDelete::class,
        \App\Commands\Product\ProductUpdate::class,

        // units
        \App\Commands\Unit\UnitList::class,
        \App\Commands\Unit\UnitAdd::class,
        \App\Commands\Unit\UnitDelete::class,
    ],

];