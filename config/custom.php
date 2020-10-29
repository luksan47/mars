<?php

return [
    'netreg' => env('NETREG', '1000'),
    'kkt' => env('KKT', '2000'),

    'workshop_balance_resident' => env('WORKSHOP_BALANCE_RESIDENT', '0.6'),
    'workshop_balance_extern' => env('WORKSHOP_BALANCE_EXTERN', '0.45'),

    'physical-first-ip' => env('PHYSICAL_FIRST_IP', '192.168.1.1'),
    'physical-last-ip' => env('PHYSICAL_LAST_IP', '192.168.2.255'),
];
