<?php

namespace app\routes;

use app\core\Router;

class Routes
{
    public static function get(): array
    {
        return [
            'get' => [
                // Rotas mais genéricas primeiro
                '' => 'HomeController@index',
                '/' => 'HomeController@index',
                'index.php' => 'HomeController@index',

                // Rotas específicas do sistema atual
                '/PHP-POO/routes-phpoo/public/' => 'HomeController@index',
                '/PHP-POO/routes-phpoo/public/index.php' => 'HomeController@index',
                'PHP-POO/routes-phpoo/public/' => 'HomeController@index',
                'PHP-POO/routes-phpoo/public/index.php' => 'HomeController@index',

                //auth
                '/PHP-POO/routes-phpoo/public/login.php' => 'AuthController@showLogin',
                'login.php' => 'AuthController@showLogin',
                '/PHP-POO/routes-phpoo/public/logout.php' => 'AuthController@logout',
                'logout.php' => 'AuthController@logout',

                //user
                '/PHP-POO/routes-phpoo/public/user.php' => 'UserController@index',
                'user.php' => 'UserController@index',
                '/PHP-POO/routes-phpoo/public/user.php/delete/([0-9]+)' => 'UserController@delete',

                //products
                '/PHP-POO/routes-phpoo/public/products.php' => 'ProductController@index',
                'products.php' => 'ProductController@index',

                //chat
                '/PHP-POO/routes-phpoo/public/chat_teste.php' => 'ChatController@index',
                'chat_teste.php' => 'ChatController@index',

                // Recursos comuns que o navegador procura automaticamente
                '/PHP-POO/routes-phpoo/public/favicon.ico' => 'AssetsController@favicon',
                'favicon.ico' => 'AssetsController@favicon',
                'robots.txt' => 'AssetsController@robots',
                'sitemap.xml' => 'AssetsController@sitemap',

                // Rotas para administração de banco de dados
                'database' => 'DatabaseController@index',
                'database.php' => 'DatabaseController@index',
                'database/test' => 'DatabaseController@test',
                '/PHP-POO/routes-phpoo/public/database' => 'DatabaseController@index',
                '/PHP-POO/routes-phpoo/public/database.php' => 'DatabaseController@index',
                '/PHP-POO/routes-phpoo/public/database/test' => 'DatabaseController@test',
                'database/export-schema' => 'DatabaseController@exportSchema',
                'database/import-schema' => 'DatabaseController@importSchema',
                'database/create-backup' => 'DatabaseController@createBackup',
                'database/restore-backup' => 'DatabaseController@restoreBackup',
                'database/download' => 'DatabaseController@downloadFile',
                'database/info' => 'DatabaseController@getDatabaseInfo',
            ],
            'post' => [
                //auth
                '/PHP-POO/routes-phpoo/public/login.php' => 'AuthController@authenticate',
                'login.php' => 'AuthController@authenticate',

                //user
                '/PHP-POO/routes-phpoo/public/user.php/edit/id=([a-zA-Z0-9]+)' => 'UserController@edit',

                //products
                '/PHP-POO/routes-phpoo/public/produtos.php/delete/([0-9]+)' => 'ProductController@delete',
                '/PHP-POO/routes-phpoo/public/produtos.php/edit/([0-9]+)' => 'ProductController@edit',

                // Rotas POST para administração de banco de dados
                'database/export-schema' => 'DatabaseController@exportSchema',
                'database/import-schema' => 'DatabaseController@importSchema',
                'database/create-backup' => 'DatabaseController@createBackup',
                'database/restore-backup' => 'DatabaseController@restoreBackup',
            ]
        ];
    }
}
