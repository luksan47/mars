<?php

return [

    'cost' => [
        'one_sided' => env('PRINT_COST_ONESIDED'),
        'two_sided' => env('PRINT_COST_TWOSIDED'),
    ],

    // Maximum accepted PDF size in byte.
    'pdf_size_limit' => 1200000,

    'printer_name' => env('PRINTER_NAME', 'ujbela'),
];