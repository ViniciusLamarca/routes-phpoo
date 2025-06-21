<?php

namespace App\Controllers;

class NotFoundController
{
    public function index()
    {
        // Não tentar definir headers se já foram enviados
        if (!headers_sent()) {
            http_response_code(404);
        }

        // Verificar se é uma requisição para recurso estático
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)(\?.*)?$/i', $uri)) {
            // Para recursos estáticos, só imprimir e sair
            echo 'Not Found';
            exit;
        }

        // Para outras páginas, mostrar mensagem HTML simples
        echo '<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página não encontrada</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            margin-top: 50px; 
            background: #f8f9fa;
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            padding: 20px;
        }
        h1 { 
            color: #dc3545; 
            font-size: 4rem;
            margin: 0;
        }
        h2 { 
            color: #6c757d; 
            margin: 20px 0;
        }
        p { 
            color: #6c757d; 
            margin: 10px 0;
        }
        a { 
            color: #007bff; 
            text-decoration: none; 
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        a:hover { 
            background: #0056b3; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>Página não encontrada</h2>
        <p>A página que você está procurando não foi encontrada.</p>
        <a href="/PHP-POO/routes-phpoo/public/index.php">← Voltar ao início</a>
    </div>
</body>
</html>';
        exit;
    }
}
