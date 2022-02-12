<?php

return [
    'redirect_url' => [
        'after_login_success' => env('EIMZO_REDIRECT_AUTH', '/'),
        'after_login_error' => env('EIMZO_REDIRECT_ERROR', '/'),

    ],
    'dsv_server_url' => env('EIMZO_DSV_SERVER_URL', '127.0.0.1')
];
