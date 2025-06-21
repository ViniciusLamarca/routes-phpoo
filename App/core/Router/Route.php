<?php

namespace App\Core\Router;

class Route
{
    private string $method;
    private string $uri;
    private $action;
    private array $middlewares = [];
    private array $parameters = [];
    private ?string $name = null;

    public function __construct(string $method, string $uri, $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function middleware(string|array $middleware): self
    {
        $this->middlewares = array_merge($this->middlewares, (array) $middleware);
        return $this;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function matches(string $method, string $uri): bool
    {
        if ($this->method !== $method) {
            return false;
        }

        return $this->matchesUri($uri);
    }

    private function matchesUri(string $uri): bool
    {
        // Remove trailing slashes
        $routeUri = rtrim($this->uri, '/');
        $requestUri = rtrim($uri, '/');

        // Exact match
        if ($routeUri === $requestUri) {
            return true;
        }

        // Check for parameter patterns
        $pattern = $this->convertToRegex($routeUri);

        if (preg_match($pattern, $requestUri, $matches)) {
            // Remove the full match from parameters
            array_shift($matches);
            $this->setParameters($matches);
            return true;
        }

        return false;
    }

    private function convertToRegex(string $uri): string
    {
        // Convert {param} to regex capture groups
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $uri);

        // Convert ([0-9]+) style patterns to proper regex
        $pattern = str_replace(['(', ')'], ['(?:', ')'], $pattern);
        $pattern = preg_replace('/\(\?\:([^)]+)\)/', '($1)', $pattern);

        return '#^' . $pattern . '$#';
    }
}
