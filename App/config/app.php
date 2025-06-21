<?php

return [
    'app' => [
        'name' => 'Routes PHP-OO',
        'version' => '1.0.0',
        'timezone' => 'America/Sao_Paulo',
        'debug' => true,
    ],

    'database' => [
        'default' => 'mysql',
        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => $_ENV['DB_HOST'] ?? 'localhost',
                'port' => $_ENV['DB_PORT'] ?? '3306',
                'database' => $_ENV['DB_DATABASE'] ?? 'service_db',
                'username' => $_ENV['DB_USERNAME'] ?? 'root',
                'password' => $_ENV['DB_PASSWORD'] ?? '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'options' => [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
                ],
            ],
        ],
    ],

    'paths' => [
        'base_url' => $_ENV['BASE_URL'] ?? '/PHP-POO/routes-phpoo/public',
        'views' => '../App/resources/views',
        'assets' => '/assets',
    ],

    'session' => [
        'driver' => 'file',
        'lifetime' => 120,
        'encrypt' => false,
    ],

    'websocket' => [
        'host' => $_ENV['WS_HOST'] ?? '127.0.0.1',
        'port' => $_ENV['WS_PORT'] ?? 8080,
    ],
];
