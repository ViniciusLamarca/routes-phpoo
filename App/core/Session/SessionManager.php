<?php

namespace App\Core\Session;

class SessionManager
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            if (isset($this->config['lifetime'])) {
                ini_set('session.gc_maxlifetime', $this->config['lifetime'] * 60);
            }
            session_start();
        }
    }

    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function put(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function flush(): void
    {
        $_SESSION = [];
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function regenerateId(bool $deleteOldSession = false): void
    {
        session_regenerate_id($deleteOldSession);
    }
}
