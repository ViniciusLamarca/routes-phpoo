<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Sistema de Mesas</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .terminal {
            background-color: #1e1e1e;
            color: #00ff00;
            font-family: 'Courier New', monospace;
            padding: 20px;
            border-radius: 5px;
            height: 400px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-database"></i> Importar Sistema de Mesas</h4>
                    </div>
                    <div class="card-body">
                        <div class="terminal" id="output">
                            <div class="mb-2">🚀 Importando Schema do Sistema de Mesas...</div>
                        </div>

                        <?php
                        if (isset($_POST['import'])) {
                            try {
                                echo "<script>document.getElementById('output').innerHTML += '<br>✅ Iniciando importação...';</script>";

                                // Conectar ao banco
                                $pdo = new PDO('mysql:host=localhost;dbname=service_db;charset=utf8mb4', 'root', '', [
                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                                ]);

                                echo "<script>document.getElementById('output').innerHTML += '<br>✅ Conectado ao banco de dados service_db';</script>";

                                // Ler o arquivo SQL (versão simplificada)
                                $sqlFile = '../App/DataBase/Schema/versions/schema_v1.1_mesas_restaurante_simple.sql';

                                if (!file_exists($sqlFile)) {
                                    throw new Exception("Arquivo SQL não encontrado: $sqlFile");
                                }

                                $sql = file_get_contents($sqlFile);
                                echo "<script>document.getElementById('output').innerHTML += '<br>📄 Arquivo SQL carregado: " . basename($sqlFile) . "';</script>";

                                // Processar comandos SQL com delimitadores especiais
                                $commands = [];
                                $currentCommand = '';
                                $delimiter = ';';
                                $lines = explode("\n", $sql);

                                foreach ($lines as $line) {
                                    $line = trim($line);

                                    // Ignorar comentários e linhas vazias
                                    if (empty($line) || preg_match('/^(--|\/\*|\s*$)/', $line)) {
                                        continue;
                                    }

                                    // Verificar mudança de delimitador
                                    if (preg_match('/^DELIMITER\s+(.+)/i', $line, $matches)) {
                                        $delimiter = trim($matches[1]);
                                        continue;
                                    }

                                    // Adicionar linha ao comando atual
                                    $currentCommand .= $line . "\n";

                                    // Verificar se chegou ao final do comando
                                    if (substr(rtrim($line), -strlen($delimiter)) === $delimiter) {
                                        // Remover o delimitador do final
                                        $currentCommand = rtrim($currentCommand);
                                        $currentCommand = substr($currentCommand, 0, -strlen($delimiter));
                                        $currentCommand = trim($currentCommand);

                                        if (!empty($currentCommand)) {
                                            $commands[] = $currentCommand;
                                        }

                                        $currentCommand = '';
                                        $delimiter = ';'; // Resetar para delimitador padrão
                                    }
                                }

                                // Adicionar último comando se existir
                                if (!empty(trim($currentCommand))) {
                                    $commands[] = trim($currentCommand);
                                }

                                echo "<script>document.getElementById('output').innerHTML += '<br>📊 Executando " . count($commands) . " comandos SQL...';</script>";

                                $executed = 0;
                                foreach ($commands as $command) {
                                    if (trim($command)) {
                                        try {
                                            $pdo->exec($command);
                                            $executed++;

                                            // Identificar o tipo de comando
                                            if (stripos($command, 'CREATE TABLE') === 0) {
                                                preg_match('/CREATE TABLE[^`]*`?([^`\s]+)`?\s*\(/i', $command, $matches);
                                                $tableName = $matches[1] ?? 'unknown';
                                                echo "<script>document.getElementById('output').innerHTML += '<br>  ✅ Tabela criada: $tableName';</script>";
                                            } elseif (stripos($command, 'INSERT') === 0) {
                                                echo "<script>document.getElementById('output').innerHTML += '<br>  ✅ Dados inseridos';</script>";
                                            } elseif (stripos($command, 'CREATE TRIGGER') === 0) {
                                                echo "<script>document.getElementById('output').innerHTML += '<br>  ✅ Trigger criado';</script>";
                                            } elseif (stripos($command, 'CREATE PROCEDURE') === 0) {
                                                echo "<script>document.getElementById('output').innerHTML += '<br>  ✅ Procedure criado';</script>";
                                            } elseif (stripos($command, 'CREATE OR REPLACE VIEW') === 0) {
                                                echo "<script>document.getElementById('output').innerHTML += '<br>  ✅ View criada';</script>";
                                            }

                                            // Flush para mostrar em tempo real
                                            ob_flush();
                                            flush();
                                        } catch (PDOException $e) {
                                            if (strpos($e->getMessage(), 'already exists') !== false) {
                                                echo "<script>document.getElementById('output').innerHTML += '<br>  ⚠️ Comando ignorado (já existe): " . substr($command, 0, 30) . "...';</script>";
                                            } else {
                                                echo "<script>document.getElementById('output').innerHTML += '<br>  ❌ Erro: " . addslashes($e->getMessage()) . "';</script>";
                                            }
                                        }
                                    }
                                }

                                echo "<script>document.getElementById('output').innerHTML += '<br><br>🎉 Importação concluída!';</script>";
                                echo "<script>document.getElementById('output').innerHTML += '<br>📊 Total de comandos executados: $executed';</script>";

                                // Verificar se as tabelas foram criadas
                                echo "<script>document.getElementById('output').innerHTML += '<br><br>🔍 Verificando tabelas criadas:';</script>";
                                $tables = ['mesas_restaurante', 'reservas', 'historico_mesas'];

                                foreach ($tables as $table) {
                                    try {
                                        $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
                                        $result = $stmt->fetch();
                                        echo "<script>document.getElementById('output').innerHTML += '<br>  ✅ $table: {$result['count']} registros';</script>";
                                    } catch (PDOException $e) {
                                        echo "<script>document.getElementById('output').innerHTML += '<br>  ❌ $table: não encontrada';</script>";
                                    }
                                }

                                echo "<script>document.getElementById('output').innerHTML += '<br><br>🚀 Sistema de Mesas ativado com sucesso!';</script>";
                                echo "<script>document.getElementById('output').innerHTML += '<br>🌐 <a href=\"tables.php\" style=\"color: #00ff00;\">Acesse o sistema aqui: tables.php</a>';</script>";
                            } catch (Exception $e) {
                                echo "<script>document.getElementById('output').innerHTML += '<br>❌ Erro: " . addslashes($e->getMessage()) . "';</script>";
                            }
                        }
                        ?>

                        <?php if (!isset($_POST['import'])): ?>
                            <form method="POST" class="mt-3">
                                <div class="alert alert-warning">
                                    <strong>⚠️ Atenção:</strong> Esta operação irá criar as tabelas do sistema de mesas no
                                    banco de dados.
                                </div>
                                <button type="submit" name="import" class="btn btn-primary btn-lg">
                                    <i class="fas fa-download"></i> Importar Sistema de Mesas
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="mt-3">
                                <a href="tables.php" class="btn btn-success btn-lg">
                                    <i class="fas fa-utensils"></i> Ir para Sistema de Mesas
                                </a>
                                <a href="import_mesas_web.php" class="btn btn-secondary">
                                    <i class="fas fa-refresh"></i> Recarregar Página
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>