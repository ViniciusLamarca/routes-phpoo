<?php

namespace App\Core;

use App\Core\Container\Container;
use App\Core\Contracts\ServiceProviderInterface;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Router\Router;

class Application
{
    private Container $container;
    private array $serviceProviders = [];
    private bool $booted = false;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->container->bind('app', $this);
    }

    public function register(ServiceProviderInterface $provider): self
    {
        $this->serviceProviders[] = $provider;
        $provider->register($this->container);

        return $this;
    }

    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        foreach ($this->serviceProviders as $provider) {
            if (method_exists($provider, 'boot')) {
                $provider->boot($this->container);
            }
        }

        $this->booted = true;
    }

    public function run(): void
    {
        $this->boot();

        try {
            $request = $this->container->make(Request::class);
            $router = $this->container->make(Router::class);

            $response = $router->dispatch($request);

            if (!$response instanceof Response) {
                if ($response === null) {
                    $response = new Response('Erro interno: resposta vazia do controller.', 500);
                } else {
                    $response = new Response((string)$response);
                }
            }

            $response->send();
        } catch (\Throwable $e) {
            $this->handleException($e);
        }
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    private function handleException(\Throwable $e): void
    {
        $config = $this->container->make('config');

        if ($config['app']['debug']) {
            throw $e;
        }

        // Log do erro (implementar sistema de logs no futuro)
        error_log($e->getMessage());

        // Renderizar página de erro
        http_response_code(500);
        echo "Erro interno do servidor";
    }
}
