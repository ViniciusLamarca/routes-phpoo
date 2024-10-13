<?php

namespace App\Controllers;

use app\controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home', ['title' => 'Início', 'page_title' => 'Página Iní   cial', 'current_page' => 'index.php']);
    }
}
