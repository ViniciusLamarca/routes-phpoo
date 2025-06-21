#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php';

use App\DataBase\Schema\DatabaseSchema; // Corrigido para o namespace correto

class DatabaseCLI
{
    private DatabaseSchema $schema;

    public function __construct()
    {
        $this->schema = new DatabaseSchema();
    }

    public function run($args)
    {
        if (!isset($args[1])) {
            $this->showHelp();
            return;
        }

        $command = $args[1];

        try {
            switch ($command) {
                case 'export':
                    $this->exportSchema($args);
                    break;
                case 'import':
                    $this->importSchema($args);
                    break;
                case 'backup':
                    $this->createBackup($args);
                    break;
                case 'restore':
                    $this->restoreBackup($args);
                    break;
                case 'list':
                    $this->listVersions();
                    break;
                case 'list-backups':
                    $this->listBackups();
                    break;
                case 'info':
                    $this->showDatabaseInfo();
                    break;
                default:
                    echo "Comando desconhecido: $command\n";
                    $this->showHelp();
            }
        } catch (Exception $e) {
            echo "❌ Erro: " . $e->getMessage() . "\n";
            exit(1);
        }
    }

    private function exportSchema($args)
    {
        $version = $args[2] ?? null;

        echo "📦 Exportando schema do banco...\n";
        $filepath = $this->schema->exportSchema($version);

        echo "✅ Schema exportado com sucesso!\n";
        echo "📁 Arquivo: $filepath\n";
    }

    private function importSchema($args)
    {
        if (!isset($args[2])) {
            echo "❌ Erro: Especifique a versão para importar\n";
            echo "Uso: php database_cli.php import <versão>\n";
            return;
        }

        $version = $args[2];

        echo "⚠️  ATENÇÃO: Esta operação pode alterar a estrutura do banco!\n";
        echo "Deseja continuar? (s/N): ";
        $confirm = trim(fgets(STDIN));

        if (strtolower($confirm) !== 's') {
            echo "❌ Operação cancelada.\n";
            return;
        }

        echo "📥 Importando schema versão '$version'...\n";
        $this->schema->importSchema($version);

        echo "✅ Schema importado com sucesso!\n";
    }

    private function createBackup($args)
    {
        $name = $args[2] ?? null;

        echo "💾 Criando backup completo do banco...\n";
        $filepath = $this->schema->createBackup($name);

        echo "✅ Backup criado com sucesso!\n";
        echo "📁 Arquivo: $filepath\n";
    }

    private function restoreBackup($args)
    {
        if (!isset($args[2])) {
            echo "❌ Erro: Especifique o arquivo de backup para restaurar\n";
            echo "Uso: php database_cli.php restore <arquivo-backup>\n";
            return;
        }

        $filename = $args[2];

        echo "⚠️  ATENÇÃO: Esta operação irá SOBRESCREVER todos os dados atuais!\n";
        echo "Deseja continuar? (s/N): ";
        $confirm = trim(fgets(STDIN));

        if (strtolower($confirm) !== 's') {
            echo "❌ Operação cancelada.\n";
            return;
        }

        echo "🔄 Restaurando backup '$filename'...\n";
        $this->schema->restoreBackup($filename);

        echo "✅ Backup restaurado com sucesso!\n";
    }

    private function listVersions()
    {
        $versions = $this->schema->listVersions();

        if (empty($versions)) {
            echo "📄 Nenhuma versão de schema encontrada.\n";
            return;
        }

        echo "📋 Versões de Schema Disponíveis:\n";
        echo "================================\n";

        foreach ($versions as $version) {
            echo sprintf(
                "🏷️  %s | %s | %s\n",
                str_pad($version['version'], 20),
                $version['created_at'],
                $version['description']
            );
        }
    }

    private function listBackups()
    {
        $backups = $this->schema->listBackups();

        if (empty($backups)) {
            echo "💾 Nenhum backup encontrado.\n";
            return;
        }

        echo "📋 Backups Disponíveis:\n";
        echo "=======================\n";

        foreach ($backups as $backup) {
            $size = $this->formatFileSize($backup['size']);
            echo sprintf(
                "💾 %s | %s | %s\n",
                str_pad($backup['filename'], 30),
                $backup['date'],
                $size
            );
        }
    }

    private function showDatabaseInfo()
    {
        try {
            $pdo = \app\dataBase\connection::connect();

            // Informações gerais
            $stmt = $pdo->query("SELECT DATABASE() as db_name");
            $dbInfo = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "📊 Informações do Banco de Dados:\n";
            echo "=================================\n";
            echo "🗄️  Nome: " . $dbInfo['db_name'] . "\n";

            // Listar tabelas
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

            echo "📋 Tabelas (" . count($tables) . "):\n";

            foreach ($tables as $table) {
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM `$table`");
                $count = $stmt->fetch(PDO::FETCH_ASSOC);

                echo sprintf("   📊 %s (%d registros)\n", $table, $count['count']);
            }
        } catch (Exception $e) {
            echo "❌ Erro ao obter informações: " . $e->getMessage() . "\n";
        }
    }

    private function formatFileSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $unit = 0;
        while ($size > 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }
        return round($size, 2) . ' ' . $units[$unit];
    }

    private function showHelp()
    {
        echo "🔧 Sistema de Gerenciamento de Banco de Dados\n";
        echo "=============================================\n\n";
        echo "Comandos disponíveis:\n\n";
        echo "  📦 export [versão]         - Exportar schema atual\n";
        echo "  📥 import <versão>         - Importar schema específico\n";
        echo "  💾 backup [nome]           - Criar backup completo\n";
        echo "  🔄 restore <arquivo>       - Restaurar backup\n";
        echo "  📋 list                    - Listar versões de schema\n";
        echo "  📋 list-backups            - Listar backups disponíveis\n";
        echo "  📊 info                    - Mostrar informações do banco\n";
        echo "  ❓ help                    - Mostrar esta ajuda\n\n";
        echo "Exemplos:\n";
        echo "  php database_cli.php export v1.0\n";
        echo "  php database_cli.php import latest\n";
        echo "  php database_cli.php backup producao_2024\n";
        echo "  php database_cli.php restore backup_2024_01_15.sql.gz\n";
    }
}

// Executar CLI
if (php_sapi_name() === 'cli') {
    $cli = new DatabaseCLI();
    $cli->run($argv);
} else {
    echo "Este script deve ser executado via linha de comando.\n";
    exit(1);
}
