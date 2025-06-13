<?php

namespace app\controllers;

use app\core\View;
use app\Middleware\AuthMiddleware;

abstract class Controller
{
    protected function view(string $view, array $data = [])
    {
        View::render($view, $data);
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
