<?php

namespace App\Core\Http;

class Request
{
    private array $query;
    private array $post;
    private array $server;
    private array $cookies;
    private array $files;
    private string $content;

    public function __construct(
        array $query = null,
        array $post = null,
        array $server = null,
        array $cookies = null,
        array $files = null,
        string $content = null
    ) {
        $this->query = $query ?? $_GET;
        $this->post = $post ?? $_POST;
        $this->server = $server ?? $_SERVER;
        $this->cookies = $cookies ?? $_COOKIE;
        $this->files = $files ?? $_FILES;
        $this->content = $content ?? file_get_contents('php://input') ?: '';
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        return parse_url($this->server['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    }

    public function fullUrl(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }

    public function get(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->query;
        }
        return $this->query[$key] ?? $default;
    }

    public function post(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->post;
        }
        return $this->post[$key] ?? $default;
    }

    public function input(string $key = null, $default = null)
    {
        $input = array_merge($this->query, $this->post);

        if ($key === null) {
            return $input;
        }
        return $input[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($this->query[$key]) || isset($this->post[$key]);
    }

    public function file(string $key)
    {
        return $this->files[$key] ?? null;
    }

    public function cookie(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->cookies;
        }
        return $this->cookies[$key] ?? $default;
    }

    public function header(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->getHeaders();
        }

        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return $this->server[$key] ?? $default;
    }

    public function isMethod(string $method): bool
    {
        return $this->method() === strtoupper($method);
    }

    public function isGet(): bool
    {
        return $this->isMethod('GET');
    }

    public function isPost(): bool
    {
        return $this->isMethod('POST');
    }

    public function isPut(): bool
    {
        return $this->isMethod('PUT');
    }

    public function isDelete(): bool
    {
        return $this->isMethod('DELETE');
    }

    public function isAjax(): bool
    {
        return strtolower($this->header('X-Requested-With', '')) === 'xmlhttprequest';
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isJson(): bool
    {
        return str_contains($this->header('Content-Type', ''), 'application/json');
    }

    public function json(): ?array
    {
        if (!$this->isJson()) {
            return null;
        }

        $decoded = json_decode($this->getContent(), true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }

    private function getHeaders(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headerName = str_replace('_', '-', substr($key, 5));
                $headers[ucwords(strtolower($headerName), '-')] = $value;
            }
        }
        return $headers;
    }
}
