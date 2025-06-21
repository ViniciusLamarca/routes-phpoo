<?php

namespace App\Core\Router;

use App\Core\Http\Request;

class RouteCollection
{
    private array $routes = [];
    private array $namedRoutes = [];

    public function add(Route $route): void
    {
        $this->routes[] = $route;

        if ($route->getName()) {
            $this->namedRoutes[$route->getName()] = $route;
        }
    }

    public function match(Request $request): ?Route
    {
        $method = $request->method();
        $uri = $request->uri();

        foreach ($this->routes as $route) {
            if ($route->matches($method, $uri)) {
                return $route;
            }
        }

        return null;
    }

    public function getByName(string $name): ?Route
    {
        return $this->namedRoutes[$name] ?? null;
    }

    public function all(): array
    {
        return $this->routes;
    }

    public function count(): int
    {
        return count($this->routes);
    }
}
