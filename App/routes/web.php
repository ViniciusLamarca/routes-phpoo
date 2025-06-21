<?php

use App\Core\Router\Router;
use App\Middleware\AuthMiddleware;

/** @var \App\Core\Application $app */
$router = $app->getContainer()->make(Router::class);

// Registrar middleware de autenticação
$app->getContainer()->bind(AuthMiddleware::class, function () {
    return new AuthMiddleware();
});

// Rotas públicas (sem autenticação)
$router->group(['middleware' => []], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('home');
    $router->get('/index.php', 'HomeController@index');

    // Autenticação
    $router->get('/login.php', 'AuthController@showLogin')->name('login');
    $router->post('/login.php', 'AuthController@authenticate');
    $router->get('/logout.php', 'AuthController@logout')->name('logout');

    // Registro (desabilitado temporariamente)
    // $router->get('/register.php', 'RegisterController@showRegister')->name('register');
    // $router->post('/register.php', 'RegisterController@register');
});

// Rotas protegidas (requer autenticação)
$router->group(['middleware' => [AuthMiddleware::class]], function (Router $router) {
    // Usuários
    $router->get('/user.php', 'UserController@index')->name('users.index');
    $router->post('/user.php/edit/id={id}', 'UserController@edit')->name('users.edit');
    $router->get('/user.php/delete/{id}', 'UserController@delete')->name('users.delete');

    // Produtos
    $router->get('/products.php', 'ProductController@index')->name('products.index');
    $router->post('/produtos.php/delete/{id}', 'ProductController@delete')->name('products.delete');
    $router->post('/produtos.php/edit/{id}', 'ProductController@edit')->name('products.edit');

    // Chat
    $router->get('/chat_teste.php', 'ChatController@index')->name('chat.index');

    // Árvores (se existir)
    // $router->get('/arvores.php', 'TreeController@index')->name('trees.index');
});
