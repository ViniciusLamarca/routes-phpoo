<?php

namespace app\core;

use app\core\RoutersFilter;

class Router
{
    private static bool $executed = false;

    public static function run()
    {
        // Prevenir execução múltipla
        if (self::$executed) {
            return;
        }
        self::$executed = true;

        try {
            $routerRegistered = new RoutersFilter;
            $router = $routerRegistered->get();

            $controller = new Controller;
            $controller->execute($router);

            /* dd($router); */
        } catch (\Throwable $e) {
            // Em caso de erro, mostrar mensagem simples
            http_response_code(500);
            echo "Erro interno: " . $e->getMessage();
        }
    }
}
