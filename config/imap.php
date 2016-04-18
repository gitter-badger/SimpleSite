<?php

return [
    'host' => env('IMAP_HOST', 'imap.gmail.com'),
    'port' => env('IMAP_PORT', 993),
    'username' => env('IMAP_USERNAME'),
    'password' => env('IMAP_PASSWORD'),
    'encryption' => env('IMAP_ENCRYPTION'),
];