<?php

namespace App\Controllers;

use App\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Verificar autenticação
        if (!isset($_SESSION['user'])) {
            header('Location: /PHP-POO/routes-phpoo/public/login.php');
            exit;
        }

        $user = $_SESSION['user'];

        $this->view('home', [
            'title' => 'Início',
            'page_title' => 'Página Inicial',
            'current_page' => 'index.php',
            'page' => 'index.php',
            'user' => $user
        ]);
    }
}
