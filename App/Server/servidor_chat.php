<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require 'C:/laragon/www/PHP-POO/routes-phpoo/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new \app\core\SistemaChat()
        )
    ),
    8080
);
//iniciar
$server->run();
