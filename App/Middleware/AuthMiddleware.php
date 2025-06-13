<?php

namespace App\Middleware;

class AuthMiddleware
{
    public static function isAuthenticated()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /PHP-POO/routes-phpoo/public/login.php');
            exit;
        }
    }

    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            header('Location: /PHP-POO/routes-phpoo/public/');
            exit;
        }
    }
}