<?php $this->layout('master', ['title' => $title, 'current_page' => 'Administrador de Banco', 'page' => 'database']); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h1 class="mb-0">
                        <i class="fas fa-database text-primary"></i>
                        Administrador de Banco de Dados
                    </h1>
                    <p class="mb-0 text-muted">Gerencie versões do schema e backups do banco de dados</p>
                </div>
                <div class="card-body">
                    <!-- Informações do Sistema -->
                    <div class="alert alert-info mb-4">
                        <h5><i class="fas fa-info-circle"></i> Status do Sistema</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Banco de Dados:</strong> service_db
                            </div>
                            <div class="col-md-4">
                                <strong>Versões Salvas:</strong> <?= count($versions) ?>
                            </div>
                            <div class="col-md-4">
                                <strong>Backups Criados:</strong> <?= count($backups) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Ações Rápidas -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center d-flex flex-column">
                                    <i class="fas fa-download fa-3x text-success mb-3"></i>
                                    <h5>Exportar Schema</h5>
                                    <p>Salvar estrutura atual do banco</p>
                                    <button class="btn btn-success mt-auto" onclick="exportCurrentSchema()">
                                        <i class="fas fa-download"></i> Exportar Agora
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center d-flex flex-column">
                                    <i class="fas fa-archive fa-3x text-warning mb-3"></i>
                                    <h5>Criar Backup</h5>
                                    <p>Backup completo com dados</p>
                                    <button class="btn btn-warning text-white mt-auto" onclick="createBackup()">
                                        <i class="fas fa-archive"></i> Criar Backup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Versões do Schema -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-code-branch text-primary"></i>
                        Versões do Schema
                    </h5>
                    <span class="badge bg-primary"><?= count($versions) ?> versões</span>
                </div>
                <div class="card-body">
                    <?php if (empty($versions)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Nenhuma versão salva ainda.</p>
                            <button class="btn btn-outline-primary btn-sm" onclick="exportCurrentSchema()">
                                Criar Primeira Versão
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-tag"></i> Versão</th>
                                        <th><i class="fas fa-calendar"></i> Data</th>
                                        <th><i class="fas fa-cogs"></i> Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($versions as $version): ?>
                                        <tr>
                                            <td>
                                                <code><?= htmlspecialchars($version['version']) ?></code>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($version['created_at']) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm"
                                                    onclick="importSchema('<?= htmlspecialchars($version['version']) ?>')"
                                                    data-bs-toggle="tooltip" title="Aplicar esta versão">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Backups -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-hdd text-warning"></i>
                        Backups Completos
                    </h5>
                    <span class="badge bg-warning text-dark"><?= count($backups) ?> backups</span>
                </div>
                <div class="card-body">
                    <?php if (empty($backups)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-archive fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Nenhum backup criado ainda.</p>
                            <button class="btn btn-outline-warning btn-sm" onclick="createBackup()">
                                Criar Primeiro Backup
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-file"></i> Arquivo</th>
                                        <th><i class="fas fa-calendar"></i> Data</th>
                                        <th><i class="fas fa-cogs"></i> Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($backups as $backup): ?>
                                        <tr>
                                            <td>
                                                <code><?= htmlspecialchars($backup['filename']) ?></code>
                                                <br>
                                                <small class="text-muted">
                                                    <?= number_format($backup['size'] / 1024, 1) ?> KB
                                                </small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($backup['date']) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="restoreBackup('<?= htmlspecialchars($backup['filename']) ?>')"
                                                    data-bs-toggle="tooltip" title="⚠️ ATENÇÃO: Sobrescreverá dados atuais">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas de Segurança -->
    <div class="row">
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i>
                        Avisos de Segurança
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-shield-alt text-success"></i> <strong>Schema:</strong> Exporta apenas a
                            estrutura (seguro)</li>
                        <li><i class="fas fa-exclamation-triangle text-warning"></i> <strong>Backup:</strong> Inclui
                            todos os dados (usar com cuidado)</li>
                        <li><i class="fas fa-ban text-danger"></i> <strong>Restaurar:</strong> Sobrescreve dados atuais
                            (irreversível)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->start('js'); ?>
<script>
    async function exportCurrentSchema() {
        try {
            const response = await fetch('/PHP-POO/routes-phpoo/public/database/export-schema', {
                method: 'POST'
            });

            const data = await response.json();

            if (data.success) {
                showNotification('success', 'Schema exportado com sucesso!');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification('error', 'Erro: ' + data.message);
            }
        } catch (error) {
            showNotification('error', 'Erro: ' + error.message);
        }
    }

    async function importSchema(version) {
        if (!confirm(`⚠️ Aplicar versão '${version}' do schema?\n\nIsso pode alterar a estrutura do banco de dados.`)) {
            return;
        }

        try {
            const response = await fetch('/PHP-POO/routes-phpoo/public/database/import-schema', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `version=${encodeURIComponent(version)}`
            });

            const data = await response.json();

            if (data.success) {
                showNotification('success', 'Schema aplicado com sucesso!');
            } else {
                showNotification('error', 'Erro: ' + data.message);
            }
        } catch (error) {
            showNotification('error', 'Erro: ' + error.message);
        }
    }

    async function createBackup() {
        const name = prompt('Nome para o backup (opcional):');
        if (name === null) return; // Cancelado

        try {
            const response = await fetch('/PHP-POO/routes-phpoo/public/database/create-backup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: name ? `name=${encodeURIComponent(name)}` : ''
            });

            const data = await response.json();

            if (data.success) {
                showNotification('success', 'Backup criado com sucesso!');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification('error', 'Erro: ' + data.message);
            }
        } catch (error) {
            showNotification('error', 'Erro: ' + error.message);
        }
    }

    async function restoreBackup(filename) {
        if (!confirm(
                `🚨 ATENÇÃO: Restaurar backup '${filename}'?\n\n⚠️ ISTO IRÁ SOBRESCREVER TODOS OS DADOS ATUAIS!\n\n✅ Certifique-se de ter um backup atual antes de prosseguir.\n\nDeseja continuar?`
            )) {
            return;
        }

        if (!confirm(
                `🚨 ÚLTIMA CONFIRMAÇÃO!\n\nVocê tem certeza ABSOLUTA que deseja restaurar o backup?\n\nEsta ação é IRREVERSÍVEL!`
            )) {
            return;
        }

        try {
            const response = await fetch('/PHP-POO/routes-phpoo/public/database/restore-backup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `filename=${encodeURIComponent(filename)}`
            });

            const data = await response.json();

            if (data.success) {
                showNotification('success', 'Backup restaurado com sucesso!');
                setTimeout(() => location.reload(), 2000);
            } else {
                showNotification('error', 'Erro: ' + data.message);
            }
        } catch (error) {
            showNotification('error', 'Erro: ' + error.message);
        }
    }

    function showNotification(type, message) {
        // Usar o sistema de notificações do tema
        if (typeof addNotification === 'function') {
            addNotification(type, message);
        } else {
            // Fallback para alert
            alert(message);
        }
    }

    // Inicializar tooltips
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
<?php $this->stop(); ?>