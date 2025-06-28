<?php

namespace App\core;

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
                throw new \Exception("View '{$view}' não encontrada em App/view ou app/view");
            }
        }

        $template = new Engine($templatePath);
        return $template->render($view, $data);
    }
}
