<?php

namespace App\Core\View;

use App\Core\Container\Container;
use App\Core\Contracts\ServiceProviderInterface;
use League\Plates\Engine;

class ViewServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->singleton(ViewFactory::class, function ($container) {
            $config = $container->make('config');
            $engine = new Engine($config['paths']['views']);
            return new ViewFactory($engine);
        });

        // Alias para compatibilidade
        $container->bind('view', ViewFactory::class);
    }
}
