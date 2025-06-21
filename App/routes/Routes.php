<?php

namespace app\routes;

class Routes
{
    public static function get(): array
    {
        return [
            'get' => [
                //home
                '/PHP-POO/routes-phpoo/public/' => 'HomeController@index',
                '/PHP-POO/routes-phpoo/public/index.php' => 'HomeController@index',

                //auth
                '/PHP-POO/routes-phpoo/public/login.php' => 'AuthController@login',
                '/PHP-POO/routes-phpoo/public/logout.php' => 'AuthController@logout',

                //user
                '/PHP-POO/routes-phpoo/public/user.php' => 'UserController@index',
                '/PHP-POO/routes-phpoo/public/user.php/delete/([0-9]+)' => 'UserController@delete',

                //products
                '/PHP-POO/routes-phpoo/public/products.php' => 'ProductController@index',

                //register (temporariamente desabilitado - usuários serão funcionários da empresa)
                // '/PHP-POO/routes-phpoo/public/register.php' => 'RegisterController@Register',

                //tree
                '/PHP-POO/routes-phpoo/public/arvores.php' => 'TreeController@index',

                //chat
                '/PHP-POO/routes-phpoo/public/chat_teste.php' => 'ChatController@index',
            ],
            'post' => [
                //auth
                '/PHP-POO/routes-phpoo/public/login.php' => 'AuthController@authenticate',

                //user
                '/PHP-POO/routes-phpoo/public/user.php/edit/id=([a-zA-Z0-9]+)' => 'UserController@edit',

                //products
                '/PHP-POO/routes-phpoo/public/produtos.php/delete/([0-9]+)' => 'ProductController@delete',
                '/PHP-POO/routes-phpoo/public/produtos.php/edit/([0-9]+)' => 'ProductController@edit',

                //register (temporariamente desabilitado - usuários serão funcionários da empresa)
                // '/PHP-POO/routes-phpoo/public/register.php' => 'RegisterController@insert',
                // '/PHP-POO/routes-phpoo/public/register.php/([a-zA-Z0-9]+)' => 'RegisterController@insert',
            ]
        ];
    }
}