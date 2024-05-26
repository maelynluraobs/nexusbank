<?php
return [
    'account_service' => [
        'base_uri' => env('ACCOUNT_SERVICE_URL', 'http://localhost:8001'),
        'timeout' => 2.0,
    ],
    'payment_service' => [
        'base_uri' => env('PAYMENT_SERVICE_URL', 'http://localhost:8003'),
        'timeout' => 2.0,
    ],
    'transaction_service' => [
        'base_uri' => env('TRANSACTION_SERVICE_URL', 'http://localhost:8002'),
        'timeout' => 2.0,
    ],
];
