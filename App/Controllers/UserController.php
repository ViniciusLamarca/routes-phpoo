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
        $user->update(['nome' => $request['name'], 'email' => $request['email'], 'password' => $request['password'], 'tipo_user' => $request['tipo_user']], "{$parameters}");
        header('location: http://localhost/PHP-POO/public/user.php');
        exit;
    }

    public function index()
    {
        $filters = new Filters();
        $filters->where('id', '>', 1);

        $users = new User();
        $users->setFilters($filters);
        $usersFound = $users->fetch_all();


        $this->view('user', ['title' => 'User Profile', 'table' => $usersFound]);
    }
    public function delete($parameters)
    {
        $parameters = intval($parameters[0]);
        $user = new User();
        $user->delete('id', $parameters);
        header('location: http://localhost/PHP-POO/public/user.php');
        exit;
    }

    public function update($parameters) {}
}
