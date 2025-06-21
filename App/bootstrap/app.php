<?php

use App\Core\Application;
use App\Core\Container\Container;
use App\Core\Database\DatabaseServiceProvider;
use App\Core\View\ViewServiceProvider;
use App\Core\Session\SessionServiceProvider;
use App\Core\Http\Request;
use App\Core\Router\Router;

// Carregar configurações
$config = require_once __DIR__ . '/../config/app.php';

// Configurar timezone
date_default_timezone_set($config['app']['timezone']);

// Inicializar container de injeção de dependências
$container = new Container();

// Registrar configurações no container
$container->bind('config', $config);

// Registrar singletons básicos
$container->singleton(Request::class, function () {
    return new Request();
});

$container->singleton(Router::class, function ($container) {
    return new Router($container);
});

// Criar aplicação
$app = new Application($container);

// Registrar service providers
$app->register(new DatabaseServiceProvider());
$app->register(new ViewServiceProvider());
$app->register(new SessionServiceProvider());

// Inicializar sessão se não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Disponibilizar globalmente para os helpers
$GLOBALS['app'] = $app;

return $app;
