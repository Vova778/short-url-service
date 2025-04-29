<?php
// config/links.php

return [
    'generator' => [
        'length' => env('LINK_CODE_LENGTH', 6),
        'uppercase' => env('LINK_CODE_UPPERCASE', false),
        'lowercase' => env('LINK_CODE_LOWERCASE', true),
        'digits' => env('LINK_CODE_DIGITS', true),
        'symbols' => env('LINK_CODE_SYMBOLS', ''),
    ],

    'blacklist' => [
        'admin',
        'login',
        'signup',
    ],
];
