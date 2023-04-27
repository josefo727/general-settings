<?php

return [
    'encryption' => [
        'enabled' => true,
        'key' => env('GENERAL_SETTINGS_ENCRYPTION_KEY', 'some_default_key'),
    ],
    'show_passwords' => env('GENERAL_SETTINGS_SHOW_PASSWORDS', false),
    'crud_web' => [
        'enable' => true,
        'middleware' => \Josefo727\GeneralSettings\Http\Middleware\TestWebMiddleware::class
    ]
];
