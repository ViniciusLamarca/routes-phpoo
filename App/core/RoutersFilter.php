<?php

namespace app\Core;

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
        if (array_key_exists($this->uri, $this->routesRegistered[$this->method])) {
            return $this->routesRegistered[$this->method][$this->uri];
        }
        return null;
    }

    private function dynamicRouter()
    {
        foreach ($this->routesRegistered[$this->method] as $index => $route) {
            $regex =  str_replace('/', '\/', trim($index, '/'));
            if ($index !== '/' && preg_match("/^$regex$/", trim($this->uri, '/'))) {
                return $route;
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
