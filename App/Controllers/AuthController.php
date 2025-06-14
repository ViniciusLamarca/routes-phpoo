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
            require_once __DIR__ . '/../helpers/notifications.php';
            add_notification('Bem-vindo, ' . $_SESSION['user']['username'], 'success');
            header('Location: /PHP-POO/routes-phpoo/public/');
            exit;
        }

        require_once __DIR__ . '/../helpers/notifications.php';
        add_notification('Email ou senha inválidos', 'aviso');
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
