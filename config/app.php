<?php

$config = [
    'app' => ['defaultLocale' => 'en_US', 'encoding' => 'UTF-8', 'defaultTimezone' => 'America/Sao_Paulo'],
    'email' => [
        'language' => 'br',
        'html' => true,
        'host' => '',
        'port' => 587,
        'SMTP' => ['auth' => true, 'secure' => false, 'debug' => 0],
        'user' => '',
        'pass' => '',
        'active' => false
    ],
    'security' => ['salt' => 32, 'time' => 1800],
    'pdf' => [
        'config' => [
            'orientation' => 'L',
            'format' => 'A4',
            'language' => 'pt',
            'unicode' => true,
            'encoding' => 'UTF-8',
            'margins' => [0, 0, 0, 0],
            'pdfa' => false,
            'active' => false
        ],
        'mode' => 'htmltopdf'
    ],
    'plugins' => [[]],
    'cache' => ['active' => false, 'expirationTime' => ''],
    'middleware' => []
];