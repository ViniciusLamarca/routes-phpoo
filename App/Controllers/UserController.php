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
        $response = request::query('page');
        dd($response);
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
    }
}
