<?php

namespace App\Core\Contracts;

use App\Core\Container\Container;

interface ServiceProviderInterface
{
    public function register(Container $container): void;
}
