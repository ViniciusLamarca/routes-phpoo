<?php

namespace app\core;

// Roteador antigo desativado. Use apenas o sistema de rotas moderno via web.php.
class Router
{
    public static function run()
    {
        throw new \Exception('O sistema de rotas antigo (Router.php) está desativado. Use apenas o roteador moderno via web.php.');
    }
}
