<?php

namespace App\Core\View;

use League\Plates\Engine;

class ViewFactory
{
    private Engine $engine;

    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    public function render(string $view, array $data = []): string
    {
        return $this->engine->render($view, $data);
    }

    public function exists(string $view): bool
    {
        $viewPath = $this->engine->getDirectory() . '/' . $view . '.php';
        return file_exists($viewPath);
    }

    public function getEngine(): Engine
    {
        return $this->engine;
    }
}
