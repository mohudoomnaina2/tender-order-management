<?php

return [
    'flow' => [
        'pending'   => ['confirmed', 'cancelled'],
        'confirmed' => ['packed'],
        'packed'    => ['shipped'],
        'shipped'   => ['delivered'],
        'delivered' => ['completed'],
    ],
];