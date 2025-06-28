<?php

namespace App\Controllers;

use app\core\View;
use app\Middleware\AuthMiddleware;

abstract class Controller
{
    protected function view(string $view, array $data = [])
    {
        return \app\core\View::render($view, $data);
    }

    protected function redirect(string $url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function requireAuth()
    {
        AuthMiddleware::isAuthenticated();
    }

    protected function requireGuest()
    {
        AuthMiddleware::isGuest();
    }
}
