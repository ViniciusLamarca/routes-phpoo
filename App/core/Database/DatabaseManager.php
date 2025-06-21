<?php

namespace App\Core\Database;

use PDO;
use PDOException;

class DatabaseManager
{
    private array $config;
    private array $connections = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function connection(string $name = null): PDO
    {
        $name = $name ?: $this->config['default'];

        if (isset($this->connections[$name])) {
            return $this->connections[$name];
        }

        return $this->connections[$name] = $this->createConnection($name);
    }

    private function createConnection(string $name): PDO
    {
        $config = $this->config['connections'][$name] ?? null;

        if (!$config) {
            throw new \InvalidArgumentException("Database connection [{$name}] not configured.");
        }

        try {
            $dsn = $this->buildDsn($config);
            $connection = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $config['options'] ?? []
            );

            return $connection;
        } catch (PDOException $e) {
            throw new \RuntimeException("Could not connect to database: " . $e->getMessage());
        }
    }

    private function buildDsn(array $config): string
    {
        return sprintf(
            '%s:host=%s;port=%s;dbname=%s;charset=%s',
            $config['driver'],
            $config['host'],
            $config['port'],
            $config['database'],
            $config['charset']
        );
    }

    public function __call(string $method, array $arguments)
    {
        return $this->connection()->$method(...$arguments);
    }
}
