<?php

namespace app\controllers;

use League\Plates\Engine;

abstract class Controller
{
    protected function view(string $view, array $data = [])
    {
        $viewPath = '../app/view/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \Exception("View {$view} not found");
        }
        $template = new Engine('../app/view');
        echo $template->render($view, $data);
    }
}
