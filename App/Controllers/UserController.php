<?php

namespace App\Controllers;

use app\core\request;
use app\dataBase\Models\User;
use app\dataBase\Filters;
use app\controllers\Controller;


class UserController extends Controller
{
    public function edit($parameters)
    {
        $request = request::all();
        $parameters = $parameters[0];
        $user = new User();
        $user->update(['nome' => $request['name'], 'email' => $request['email'], 'password' => $request['password'], 'cargo' => $request['cargo']], "{$parameters}");
        header('location: /PHP-POO/routes-phpoo/public/user.php');
        exit;
    }

    public function index()
    {
        $filters = new Filters();
        $filters->where('id_usuario', '>', 1);
        $users = new User();
        $users->setFilters($filters);
        $usersFound = $users->fetch_all();

        return $this->view('user', ['title' => 'Usuário', 'table' => $usersFound, 'page' => 'user.php']);
    }
    public function delete($parameters)
    {
        $parameters = intval($parameters[0]);
        $user = new User();
        $user->delete('id_usuario', $parameters);
        header('location:/PHP-POO/routes-phpoo/public/user.php');
        exit;
    }

    public function update($parameters) {}
}
