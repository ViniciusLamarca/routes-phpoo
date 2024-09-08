<?php

namespace app\routes;



class Routes
{
    public static function get(): array
    {
        return [
            'get' => [
                '/PHP-POO/public/' => 'HomeController@index',
                '/PHP-POO/public/index.php' => 'HomeController@index',

                '/PHP-POO/public/user.php' => 'UserController@index',

                '/PHP-POO/public/user.php/delete/([0-9]+)' => 'UserController@delete',

                '/PHP-POO/public/products.php' => 'ProductController@index',

                '/PHP-POO/public/register.php' => 'RegisterController@Register',

            ],
            'post' => [
                '/PHP-POO/public/user.php/edit/id=([a-zA-Z0-9]+)' => 'UserController@edit',
                '/PHP-POO/public/register.php/([a-zA-Z0-9]+)' => 'RegisterController@insert',
            ]
        ];
    }
}
