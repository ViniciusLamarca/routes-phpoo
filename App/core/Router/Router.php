<?php

namespace App\Core\Router;

use App\Core\Container\Container;
use App\Core\Http\Request;
use App\Core\Http\Response;

class Router
{
    private Container $container;
    private RouteCollection $routes;
    private array $middlewares = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->routes = new RouteCollection();
    }

    public function get(string $uri, $action): Route
    {
        return $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, $action): Route
    {
        return $this->addRoute('POST', $uri, $action);
    }

    public function put(string $uri, $action): Route
    {
        return $this->addRoute('PUT', $uri, $action);
    }

    public function delete(string $uri, $action): Route
    {
        return $this->addRoute('DELETE', $uri, $action);
    }

    public function patch(string $uri, $action): Route
    {
        return $this->addRoute('PATCH', $uri, $action);
    }

    public function any(string $uri, $action): Route
    {
        $methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];
        $route = null;

        foreach ($methods as $method) {
            $route = $this->addRoute($method, $uri, $action);
        }

        return $route;
    }

    private function addRoute(string $method, string $uri, $action): Route
    {
        $route = new Route($method, $uri, $action);
        $this->routes->add($route);
        return $route;
    }

    public function group(array $attributes, callable $callback): void
    {
        $oldMiddlewares = $this->middlewares;

        if (isset($attributes['middleware'])) {
            $this->middlewares = array_merge($this->middlewares, (array) $attributes['middleware']);
        }

        $callback($this);

        $this->middlewares = $oldMiddlewares;
    }

    public function dispatch(Request $request)
    {
        $route = $this->routes->match($request);

        if ($route === null) {
            return $this->handleNotFound();
        }

        return $this->runRoute($request, $route);
    }

    private function runRoute(Request $request, Route $route)
    {
        $middlewares = array_merge($this->middlewares, $route->getMiddlewares());

        // Aplicar middlewares
        foreach ($middlewares as $middleware) {
            $middlewareInstance = $this->container->make($middleware);
            if (method_exists($middlewareInstance, 'handle')) {
                $middlewareInstance->handle($request);
            }
        }

        return $this->callAction($request, $route);
    }

    private function callAction(Request $request, Route $route)
    {
        $action = $route->getAction();

        if (is_string($action) && str_contains($action, '@')) {
            [$controller, $method] = explode('@', $action);

            $controllerClass = "App\\Controllers\\{$controller}";

            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller [{$controllerClass}] not found");
            }

            $controllerInstance = $this->container->make($controllerClass);

            if (!method_exists($controllerInstance, $method)) {
                throw new \Exception("Method [{$method}] not found in [{$controllerClass}]");
            }

            $parameters = $route->getParameters();
            return $controllerInstance->$method($request, ...$parameters);
        }

        if (is_callable($action)) {
            $parameters = $route->getParameters();
            return call_user_func_array($action, [$request, ...$parameters]);
        }

        throw new \Exception("Invalid route action");
    }

    private function handleNotFound()
    {
        try {
            $controller = $this->container->make('App\\Controllers\\NotFoundController');
            return $controller->index();
        } catch (\Exception $e) {
            return new Response('404 - Page Not Found', 404);
        }
    }
}
