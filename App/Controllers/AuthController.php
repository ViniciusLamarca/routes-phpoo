<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Database\Models\Login;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Se já está logado, redireciona para home
        if (isset($_SESSION['user'])) {
            header('Location: /PHP-POO/routes-phpoo/public/');
            exit;
        }

        $this->view('auth/login', [
            'title' => 'Login',
            'old_input' => $_SESSION['old_input'] ?? []
        ]);

        // Limpar old_input da sessão
        unset($_SESSION['old_input']);
    }

    public function authenticate()
    {
        $identifier = $_POST['email'] ?? ''; // No form é "email" mas aceita email ou username
        $password = $_POST['password'] ?? '';

        // Validação básica
        if (empty($identifier) || empty($password)) {
            // Usar novo sistema de notificações
            if (function_exists('add_notification')) {
                add_notification('Email/usuário e senha são obrigatórios', 'error');
            }
            $_SESSION['old_input'] = ['email' => $identifier];
            header('Location: /PHP-POO/routes-phpoo/public/login');
            exit;
        }

        // Buscar usuário no banco usando o modelo antigo
        $loginModel = new Login();
        $user = $loginModel->authenticate($identifier, $password);

        if (!$user) {
            // Usar novo sistema de notificações
            if (function_exists('add_notification')) {
                add_notification('Credenciais inválidas. Verifique seu email/usuário e senha.', 'error');
            }
            $_SESSION['old_input'] = ['email' => $identifier];
            header('Location: /PHP-POO/routes-phpoo/public/login');
            exit;
        }

        // Login bem-sucedido - manter formato original da sessão
        $_SESSION['user'] = [
            'id' => $user->id,
            'username' => $user->username ?? $user->nome,
            'nome' => $user->nome ?? $user->username,
            'email' => $user->email,
            'cargo' => $user->cargo // Usar cargo na sessão (padrão do sistema)
        ];

        if (function_exists('add_notification')) {
            add_notification('Login realizado com sucesso! Bem-vindo(a), ' . $user->username, 'success');
        }

        header('Location: /PHP-POO/routes-phpoo/public/');
        exit;
    }

    public function logout()
    {
        // Obter nome do usuário antes de destruir sessão
        $username = $_SESSION['user']['username'] ?? 'Usuário';

        // Limpar sessão
        session_destroy();

        if (function_exists('add_notification')) {
            add_notification('Logout realizado com sucesso! Até logo, ' . $username . '!', 'info');
        }

        header('Location: /PHP-POO/routes-phpoo/public/login');
        exit;
    }
}
