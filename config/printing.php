<?php
return [

    'enabled' => env('PRINTING_SUBSYSTEM_ENABLED', false),
    'printer_name' => env('PRINTER_NAME'),
    'utility_args' => env('PRINTING_UTILITY_ARGS', '-h localhost:631'),
	
	'cost_one_sided' =>  8,
	'cost_two_sided' => 12,
];
