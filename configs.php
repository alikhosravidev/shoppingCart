<?php

return [

    'database' => [
        'path' => __DIR__.'/database.json',
    ],

    'commands' => [
        // products
        \App\Commands\Products\ProductList::class,
        \App\Commands\Products\ProductAdd::class,
        \App\Commands\Products\ProductDelete::class,
    ],

];