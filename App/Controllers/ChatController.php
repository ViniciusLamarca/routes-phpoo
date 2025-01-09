<?php

namespace app\controllers;

use app\controllers\Controller;

class ChatController extends Controller
{
    public function index()
    {
        $this->view('chat_teste', ['title' => 'Chat']);
    }
}
