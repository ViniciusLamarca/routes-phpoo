<?php

namespace app\dataBase;

use PDO;

class connection
{
    private static $connection = null;

    public static function connect()
    {
        if (!self::$connection) {
            self::$connection = new PDO('mysql:host=localhost;dbname=service_db', 'root', '', [
                pdo::ATTR_DEFAULT_FETCH_MODE => pdo::FETCH_OBJ,
                pdo::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            ]);
        }
        return self::$connection;
    }
}
