<?php

return [
    'out_format' => [
        'date' => 'Y-m-d',
        'time' => 'H:i:s',
        'date_time' => 'Y-m-d H:i:s',
    ],
    'encryption' => [
        'enabled' => true,
        'key' => env('GENERAL_SETTINGS_ENCRYPTION_KEY', 'some_default_key'),
    ],
    'css_framework' => env('GENERAL_SETTINGS_CSS_FRAMEWORK', 'bootstrap'), // 'bootstrap', 'tailwind', 'custom'
];
