<?php

namespace app\core;

use League\Plates\Engine;

class View
{
    public static function render(string $view, array $data = [])
    {
        $viewPath = '../app/view/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \Exception("View {$view} not found");
        }
        $template = new Engine('../app/view');
        echo $template->render($view, $data);
    }
}
