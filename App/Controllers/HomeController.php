<?php

namespace App\Controllers;

use app\controllers\Controller;
use app\Middleware\AuthMiddleware;

class HomeController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::isAuthenticated();
    }

    public function index()
    {
        $user = $_SESSION['user'];
        $this->view('home', [
            'title' => 'Início',
            'page_title' => 'Página Inicial',
            'current_page' => 'index.php',
            'user' => $user
        ]);
    }
}
