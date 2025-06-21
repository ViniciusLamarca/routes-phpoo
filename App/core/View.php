<?php

namespace app\core;

use League\Plates\Engine;

class View
{
    public static function render(string $view, array $data = [])
    {
        // Tentar primeiro no diretório App/view
        $viewPath = __DIR__ . '/../view/' . $view . '.php';
        $templatePath = __DIR__ . '/../view';

        if (!file_exists($viewPath)) {
            // Fallback para app/view se não encontrar
            $viewPath = '../app/view/' . $view . '.php';
            $templatePath = '../app/view';

            if (!file_exists($viewPath)) {
                throw new \Exception("View {$view} not found in App/view or app/view");
            }
        }

        $template = new Engine($templatePath);
        echo $template->render($view, $data);
    }
}
