<?php

namespace App\Controllers;

use app\controllers\Controller;
use app\core\request;
use app\dataBase\Models\User;
use app\Middleware\AuthMiddleware;

class AuthController extends Controller
{
    public function login()
    {
        AuthMiddleware::isGuest();
        $this->view('auth/login', ['title' => 'Login']);
    }

    public function authenticate()
    {
        AuthMiddleware::isGuest();
        $data = request::all();
        
        $user = new User();
        $authenticated = $user->authenticate($data['email'], $data['password']);

        if ($authenticated) {
            $_SESSION['user'] = $authenticated;
            header('Location: /PHP-POO/routes-phpoo/public/');
            exit;
        }

        $_SESSION['error'] = 'Email ou senha inválidos';
        header('Location: /PHP-POO/routes-phpoo/public/login.php');
        exit;
    }

    public function logout()
    {
        session_destroy();
        header('Location: /PHP-POO/routes-phpoo/public/login.php');
        exit;
    }
}