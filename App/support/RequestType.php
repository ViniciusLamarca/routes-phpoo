<?php

namespace app\support;

class RequestType
{
    public static function get()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        return strtolower($requestMethod);
    }
}
