<?php

return [
    'channels' => [
        'kavenegar' => [
            'class' => '',
            'base_uri' => env('KAVENEGAR_BASE_URI', 'https://api.kavenegar.com'),
            'sender' => env('KAVENEGAR_SENDER', ''),
            'key' => env('KAVENEGAR_API_KEY', ''),
        ]
    ]
];