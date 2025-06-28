<?php

namespace App\Controllers;

use app\controllers\Controller;
use app\Middleware\AuthMiddleware;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->requireAuth();
    }

    public function index()
    {
        $user = $_SESSION['user'];
        return $this->view('chat_teste', [
            'title' => 'Chat',
            'user' => $user
        ]);
    }
}
