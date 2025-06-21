<?php

namespace App\Middleware;

use App\Core\Http\Request;

class AuthMiddleware
{
    public function handle(Request $request): void
    {
        $this->isAuthenticated();
    }

    public static function isAuthenticated(): void
    {
        if (!isset($_SESSION['user'])) {
            $baseUrl = $_ENV['BASE_URL'] ?? '/PHP-POO/routes-phpoo/public';
            header("Location: {$baseUrl}/login.php");
            exit;
        }
    }

    public static function isGuest(): void
    {
        if (isset($_SESSION['user'])) {
            $baseUrl = $_ENV['BASE_URL'] ?? '/PHP-POO/routes-phpoo/public';
            header("Location: {$baseUrl}/");
            exit;
        }
    }
}
