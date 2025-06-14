<?php

use app\core\Router;


require '../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

Router::run();
