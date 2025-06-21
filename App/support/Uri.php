<?php

namespace app\support;

class Uri
{
    public static function get()
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        return trim(parse_url($requestUri, PHP_URL_PATH), '/');
    }
}
