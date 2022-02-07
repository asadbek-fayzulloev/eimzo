<?php

return [
    'redirect_url' => [
        'after_login' => env('EIMZO_REDIRECT_AUTH', '/')
    ],
    'dsv_server_url' => env('EIMZO_DSV_SERVER_URL', '127.0.0.1')
];
