<?php

require '../vendor/autoload.php';

use app\core\Router;

session_start();

Router::run();
