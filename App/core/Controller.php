<?php


namespace app\core;

class Controller
{

    public function execute(string $router)
    {

        if (!str_contains($router, '@')) {
            throw new \Exception('Invalid route');
        }

        list($controller, $method) = explode('@', $router);

        $namespace = 'app\controllers\\';
        $controllerNamespace = $namespace . $controller;

        if (!class_exists($controllerNamespace)) {
            throw new \Exception("Controller : {$controllerNamespace} not found");
        }

        $controller = new $controllerNamespace;
        //dd($controller);
        if (!method_exists($controller, $method)) {
            throw new \Exception("Method : {$method} not found in {$controllerNamespace}");
        }
        $parameters = new ControllerParams;
        $parameters = $parameters->get($router);
        $controller->$method($parameters);
    }
}
