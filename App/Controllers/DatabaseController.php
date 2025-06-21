<?php

namespace App\Controllers;

use App\Controllers\Controller;

class DatabaseController extends Controller
{
    /**
     * Página principal do administrador de banco
     */
    public function index()
    {
        try {
            $data = [
                'page' => 'database-admin',
                'title' => 'Administrador de Banco de Dados',
                'versions' => [], // Temporariamente vazio
                'backups' => []   // Temporariamente vazio
            ];

            return $this->view('database/admin', $data);
        } catch (\Exception $e) {
            // Fallback para erro
            echo "<h1>Sistema de Versionamento de Banco</h1>";
            echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
            echo "<p>Stack trace: " . $e->getTraceAsString() . "</p>";
            echo "<p>Linha: " . $e->getLine() . " Arquivo: " . $e->getFile() . "</p>";
        }
    }

    /**
     * Exportar estrutura atual
     */
    public function exportSchema()
    {
        $response = [
            'success' => false,
            'message' => 'Funcionalidade temporariamente desabilitada para debug'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Importar estrutura
     */
    public function importSchema()
    {
        $response = [
            'success' => false,
            'message' => 'Funcionalidade temporariamente desabilitada para debug'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Criar backup completo
     */
    public function createBackup()
    {
        $response = [
            'success' => false,
            'message' => 'Funcionalidade temporariamente desabilitada para debug'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Restaurar backup
     */
    public function restoreBackup()
    {
        $response = [
            'success' => false,
            'message' => 'Funcionalidade temporariamente desabilitada para debug'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Download de arquivo de schema ou backup
     */
    public function downloadFile()
    {
        http_response_code(404);
        echo "Funcionalidade temporariamente desabilitada para debug";
    }

    /**
     * Obter informações do banco atual
     */
    public function getDatabaseInfo()
    {
        try {
            $pdo = \app\dataBase\connection::connect();

            // Informações gerais
            $stmt = $pdo->query("SELECT DATABASE() as db_name");
            $dbInfo = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Listar tabelas
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(\PDO::FETCH_COLUMN);

            // Informações de cada tabela
            $tableInfo = [];
            foreach ($tables as $table) {
                $stmt = $pdo->query("SELECT COUNT(*) as row_count FROM `$table`");
                $count = $stmt->fetch(\PDO::FETCH_ASSOC);

                $tableInfo[] = [
                    'name' => $table,
                    'row_count' => $count['row_count']
                ];
            }

            $response = [
                'success' => true,
                'database' => $dbInfo['db_name'],
                'tables' => $tableInfo,
                'total_tables' => count($tables)
            ];
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Erro ao obter informações: ' . $e->getMessage()
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
