<?php

use App\Core\Application;
use App\Core\Container\Container;

if (!function_exists('app')) {
    /**
     * Obter instância da aplicação ou resolver binding do container
     */
    function app(?string $abstract = null, array $parameters = [])
    {
        static $application = null;

        if ($application === null) {
            // Se não temos a aplicação ainda, tenta obter do global
            $application = $GLOBALS['app'] ?? null;
        }

        if ($abstract === null) {
            return $application;
        }

        return $application->getContainer()->make($abstract);
    }
}

if (!function_exists('config')) {
    /**
     * Obter valor de configuração
     */
    function config(string $key = null, $default = null)
    {
        $config = app('config');

        if ($key === null) {
            return $config;
        }

        $keys = explode('.', $key);
        $value = $config;

        foreach ($keys as $k) {
            if (!is_array($value) || !array_key_exists($k, $value)) {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }
}

if (!function_exists('view')) {
    /**
     * Renderizar view
     */
    function view(string $view, array $data = []): string
    {
        return app('view')->render($view, $data);
    }
}

if (!function_exists('session')) {
    /**
     * Obter gerenciador de sessão
     */
    function session(?string $key = null, $default = null)
    {
        $session = app('session');

        if ($key === null) {
            return $session;
        }

        return $session->get($key, $default);
    }
}

if (!function_exists('request')) {
    /**
     * Obter instância da requisição atual
     */
    function request(): \App\Core\Http\Request
    {
        return app(\App\Core\Http\Request::class);
    }
}

if (!function_exists('response')) {
    /**
     * Criar nova resposta
     */
    function response(string $content = '', int $status = 200): \App\Core\Http\Response
    {
        return new \App\Core\Http\Response($content, $status);
    }
}

if (!function_exists('redirect')) {
    /**
     * Criar resposta de redirecionamento
     */
    function redirect(string $url, int $status = 302): \App\Core\Http\Response
    {
        return response()->redirect($url, $status);
    }
}
