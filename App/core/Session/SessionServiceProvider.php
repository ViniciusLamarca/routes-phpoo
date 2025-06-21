<?php

namespace App\Core\Session;

use App\Core\Container\Container;
use App\Core\Contracts\ServiceProviderInterface;

class SessionServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->singleton(SessionManager::class, function ($container) {
            $config = $container->make('config');
            return new SessionManager($config['session']);
        });

        // Alias para compatibilidade
        $container->bind('session', SessionManager::class);
    }

    public function boot(Container $container): void
    {
        $sessionManager = $container->make(SessionManager::class);
        $sessionManager->start();
    }
}
