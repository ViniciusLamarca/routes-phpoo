<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste do Sistema de Mesas</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .test-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .test-error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .test-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-check-circle"></i> Teste do Sistema de Mesas</h4>
                    </div>
                    <div class="card-body">

                        <?php
                        $tests = [];

                        try {
                            // Teste 1: Conexão com banco
                            $pdo = new PDO('mysql:host=localhost;dbname=service_db;charset=utf8mb4', 'root', '', [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                            ]);
                            $tests[] = ['status' => 'success', 'test' => 'Conexão com Banco', 'message' => 'Conectado com sucesso ao banco service_db'];

                            // Teste 2: Verificar tabelas
                            $tables = ['mesas_restaurante', 'reservas', 'historico_mesas'];
                            $foundTables = [];

                            foreach ($tables as $table) {
                                $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
                                if ($stmt->rowCount() > 0) {
                                    $foundTables[] = $table;
                                }
                            }

                            if (count($foundTables) === count($tables)) {
                                $tests[] = ['status' => 'success', 'test' => 'Estrutura de Tabelas', 'message' => 'Todas as tabelas foram criadas: ' . implode(', ', $foundTables)];
                            } else {
                                $missing = array_diff($tables, $foundTables);
                                $tests[] = ['status' => 'error', 'test' => 'Estrutura de Tabelas', 'message' => 'Tabelas faltando: ' . implode(', ', $missing)];
                            }

                            // Teste 3: Dados iniciais
                            $stmt = $pdo->query("SELECT COUNT(*) as count FROM mesas_restaurante");
                            $mesasCount = $stmt->fetch()['count'];

                            if ($mesasCount > 0) {
                                $tests[] = ['status' => 'success', 'test' => 'Dados Iniciais', 'message' => "Encontradas $mesasCount mesas cadastradas"];
                            } else {
                                $tests[] = ['status' => 'error', 'test' => 'Dados Iniciais', 'message' => 'Nenhuma mesa encontrada'];
                            }

                            // Teste 4: Estatísticas por status
                            $stmt = $pdo->query("SELECT status, COUNT(*) as count FROM mesas_restaurante GROUP BY status");
                            $stats = $stmt->fetchAll();

                            if (count($stats) > 0) {
                                $statsText = [];
                                foreach ($stats as $stat) {
                                    $statsText[] = "{$stat['status']}: {$stat['count']}";
                                }
                                $tests[] = ['status' => 'success', 'test' => 'Distribuição por Status', 'message' => implode(', ', $statsText)];
                            } else {
                                $tests[] = ['status' => 'info', 'test' => 'Distribuição por Status', 'message' => 'Nenhum dado de status encontrado'];
                            }

                            // Teste 5: Reservas
                            $stmt = $pdo->query("SELECT COUNT(*) as count FROM reservas");
                            $reservasCount = $stmt->fetch()['count'];

                            if ($reservasCount > 0) {
                                $tests[] = ['status' => 'success', 'test' => 'Sistema de Reservas', 'message' => "Encontradas $reservasCount reservas de exemplo"];
                            } else {
                                $tests[] = ['status' => 'info', 'test' => 'Sistema de Reservas', 'message' => 'Nenhuma reserva cadastrada (normal para instalação nova)'];
                            }

                            // Teste 6: Views criadas
                            $views = ['vw_ocupacao_mesas', 'vw_reservas_ativas'];
                            $foundViews = [];

                            foreach ($views as $view) {
                                try {
                                    $stmt = $pdo->query("SELECT 1 FROM $view LIMIT 1");
                                    $foundViews[] = $view;
                                } catch (Exception $e) {
                                    // View não existe
                                }
                            }

                            if (count($foundViews) === count($views)) {
                                $tests[] = ['status' => 'success', 'test' => 'Views de Relatório', 'message' => 'Todas as views foram criadas: ' . implode(', ', $foundViews)];
                            } else {
                                $missing = array_diff($views, $foundViews);
                                $tests[] = ['status' => 'error', 'test' => 'Views de Relatório', 'message' => 'Views faltando: ' . implode(', ', $missing)];
                            }

                            // Teste 7: Teste de funcionalidade básica
                            try {
                                $stmt = $pdo->prepare("SELECT * FROM mesas_restaurante WHERE status = ? LIMIT 1");
                                $stmt->execute(['disponivel']);
                                $mesa = $stmt->fetch();

                                if ($mesa) {
                                    $tests[] = ['status' => 'success', 'test' => 'Consulta Funcional', 'message' => "Mesa {$mesa['numero_mesa']} está disponível"];
                                } else {
                                    $tests[] = ['status' => 'info', 'test' => 'Consulta Funcional', 'message' => 'Sistema funciona, mas nenhuma mesa disponível encontrada'];
                                }
                            } catch (Exception $e) {
                                $tests[] = ['status' => 'error', 'test' => 'Consulta Funcional', 'message' => 'Erro ao consultar mesas: ' . $e->getMessage()];
                            }
                        } catch (Exception $e) {
                            $tests[] = ['status' => 'error', 'test' => 'Conexão com Banco', 'message' => 'Erro: ' . $e->getMessage()];
                        }
                        ?>

                        <!-- Resultados dos Testes -->
                        <h5>Resultados dos Testes:</h5>

                        <?php foreach ($tests as $test): ?>
                            <div class="alert test-<?= $test['status'] ?> mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>
                                            <?php if ($test['status'] === 'success'): ?>
                                                ✅
                                            <?php elseif ($test['status'] === 'error'): ?>
                                                ❌
                                            <?php else: ?>
                                                ℹ️
                                            <?php endif; ?>
                                            <?= $test['test'] ?>:
                                        </strong>
                                        <?= $test['message'] ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Resumo -->
                        <?php
                        $successCount = count(array_filter($tests, fn($t) => $t['status'] === 'success'));
                        $totalTests = count($tests);
                        $successRate = round(($successCount / $totalTests) * 100, 1);
                        ?>

                        <div class="mt-4 p-3 bg-light rounded">
                            <h6>Resumo dos Testes:</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Total de Testes:</strong> <?= $totalTests ?>
                                </div>
                                <div class="col-md-4">
                                    <strong>Sucessos:</strong> <?= $successCount ?>
                                </div>
                                <div class="col-md-4">
                                    <strong>Taxa de Sucesso:</strong> <?= $successRate ?>%
                                </div>
                            </div>
                        </div>

                        <!-- Ações -->
                        <div class="mt-4">
                            <?php if ($successRate >= 80): ?>
                                <div class="alert alert-success">
                                    <strong>🎉 Sistema está funcionando corretamente!</strong><br>
                                    Você pode usar o sistema de mesas normalmente.
                                </div>
                                <a href="tables.php" class="btn btn-success btn-lg me-2">
                                    <i class="fas fa-utensils"></i> Ir para Sistema de Mesas
                                </a>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <strong>⚠️ Sistema precisa de atenção!</strong><br>
                                    Alguns testes falharam. Recomenda-se executar a importação novamente.
                                </div>
                                <a href="import_mesas_web.php" class="btn btn-warning btn-lg me-2">
                                    <i class="fas fa-download"></i> Reimportar Sistema
                                </a>
                            <?php endif; ?>

                            <a href="reservations.php" class="btn btn-outline-primary me-2">
                                <i class="fas fa-calendar"></i> Sistema de Reservas
                            </a>

                            <a href="test_mesas.php" class="btn btn-outline-secondary">
                                <i class="fas fa-refresh"></i> Executar Testes Novamente
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>