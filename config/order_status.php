<?php

return [
    'valid' => [
        'pending',
        'confirmed',
        'packed',
        'shipped',
        'delivered',
        'completed',
        'cancelled',
    ],
    'flow' => [
        'pending'   => ['confirmed', 'cancelled'],
        'confirmed' => ['packed'],
        'packed'    => ['shipped'],
        'shipped'   => ['delivered'],
        'delivered' => ['completed'],
    ],
    'warehouse_allowed' => [
        'packed',
        'shipped',
    ],
];