<?php

namespace app\core;

use app\support\Uri;
use app\routes\Routes;
use app\support\RequestType;

class RoutersFilter
{
    private string $uri;
    private string $method;
    private array $routesRegistered;

    public function __construct()
    {
        $this->uri = Uri::get();
        $this->method = RequestType::get();
        $this->routesRegistered = Routes::get();
    }

    private function simpleRouter()
    {
        if (
            isset($this->routesRegistered[$this->method]) &&
            array_key_exists($this->uri, $this->routesRegistered[$this->method])
        ) {
            return $this->routesRegistered[$this->method][$this->uri];
        }
        return null;
    }

    private function dynamicRouter()
    {
        if (!isset($this->routesRegistered[$this->method])) {
            return null;
        }

        foreach ($this->routesRegistered[$this->method] as $index => $route) {
            $pattern = trim($index, '/');
            $uriToMatch = trim($this->uri, '/');

            if ($pattern === $uriToMatch) {
                return $route;
            }

            if (strpos($pattern, '(') !== false) {
                $regex = str_replace('/', '\/', $pattern);
                if (preg_match("/^$regex$/", $uriToMatch)) {
                    return $route;
                }
            }
        }
        return null;
    }

    public function get()
    {
        $simpleRouter = $this->simpleRouter();
        if ($simpleRouter) {
            return $simpleRouter;
        }
        $dynamicRouter = $this->dynamicRouter();
        if ($dynamicRouter) {
            return $dynamicRouter;
        }
        return 'NotFoundController@index';
    }
}
