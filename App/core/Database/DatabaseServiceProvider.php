<?php

namespace App\Core\Database;

use App\Core\Container\Container;
use App\Core\Contracts\ServiceProviderInterface;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->singleton(DatabaseManager::class, function ($container) {
            $config = $container->make('config');
            return new DatabaseManager($config['database']);
        });

        // Alias para compatibilidade
        $container->bind('db', DatabaseManager::class);
    }
}
