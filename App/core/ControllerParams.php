<?php

namespace app\core;

use app\support\Uri;
use app\routes\Routes;
use app\support\RequestType;

class ControllerParams
{
    public function get(string $router)
    {
        $routes = Routes::get();
        $uri = Uri::get();
        $method = RequestType::get();

        $Router = array_search($router, $routes[$method]);
        $explodedUri = explode('/', $uri);
        $explodedRouter = explode('/', $Router);
        $explodedRouter = array_filter($explodedRouter);
        $explodedRouter = array_values($explodedRouter);

        $params = [];
        foreach ($explodedRouter as $index => $value) {
            if ($value !== $explodedUri[$index]) {
                $params[$index] = $explodedUri[$index];
            }
        }
        return array_values($params);
    }
}
