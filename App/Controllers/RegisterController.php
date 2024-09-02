<?php

namespace App\Controllers;

use app\core\request;
use app\controllers\Controller;

class RegisterController extends Controller
{
    public function Register()
    {
        $this->view('register', ['title' => 'Register']);
    }

    public function insert()
    {
        $teste = request::all();

        $register = new \app\dataBase\Models\Register();
        $register->create($teste);
    }
}
