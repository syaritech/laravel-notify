<?php

use Syaritech\Notify\Channels\Kavenegar;

return [
    'channels' => [
        'kavenegar' => [
            'class' => Kavenegar::class,
            'gateway' => env('NOTIFY_KAVENEGAR_GATEWAY', 'https://api.kavenegar.com'),
            'sender' => env('NOTIFY_KAVENEGAR_SENDER', ''),
            'key' => env('NOTIFY_KAVENEGAR_API_KEY', ''),
        ]
    ]
];