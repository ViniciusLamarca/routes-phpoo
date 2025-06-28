<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Criar diretório de logs se não existir
if (!is_dir(__DIR__ . '/../logs')) {
    mkdir(__DIR__ . '/../logs', 0755, true);
}

try {
    require_once __DIR__ . '/../vendor/autoload.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Carregar bootstrap moderno e rotas protegidas
    $app = require_once __DIR__ . '/../App/bootstrap/app.php';
    require_once __DIR__ . '/../App/routes/web.php';

    $app->run();
} catch (Exception $e) {
    error_log("ERRO Exception: " . $e->getMessage() . " em " . $e->getFile() . " linha " . $e->getLine());
    http_response_code(500);
    echo "Erro interno do servidor.";
} catch (Error $e) {
    error_log("ERRO Fatal: " . $e->getMessage() . " em " . $e->getFile() . " linha " . $e->getLine());
    http_response_code(500);
    echo "Erro interno do servidor.";
} catch (Throwable $e) {
    error_log("ERRO Throwable: " . $e->getMessage() . " em " . $e->getFile() . " linha " . $e->getLine());
    http_response_code(500);
    echo "Erro interno do servidor.";
}
