<?php

namespace App\Controllers;

use app\controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home', ['title' => 'Home', 'page_title' => 'Página Inicial', 'current_page' => 'index.php']);
    }
}
