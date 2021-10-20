<?php

return [
    'sberbank' => [

        'username' => env('SBERBANK_USERNAME', 'sber-test'),
        'password' => env('SBERBANK_PASSWORD', 'sber-pass'),
        'return_url' => '/payment',
        'fail_url' => '/payment/fail',

    ]
];
