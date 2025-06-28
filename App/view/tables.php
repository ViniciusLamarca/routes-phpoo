<?php $this->layout('master', ['title' => $title, 'current_page' => $current_page, 'page' => $page]); ?>

<div class="container-fluid">
    <!-- Header da página -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-utensils text-primary"></i>
                Controle de Mesas
            </h2>
            <p class="text-muted mb-0">Gerencie o status e disponibilidade das mesas do restaurante</p>
        </div>
    </div>

    <!-- Estatísticas das mesas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?= $stats['disponivel'] ?? 0 ?></h4>
                            <p class="card-text">Disponíveis</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?= $stats['ocupada'] ?? 0 ?></h4>
                            <p class="card-text">Ocupadas</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?= $stats['reservada'] ?? 0 ?></h4>
                            <p class="card-text">Reservadas</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?= $stats['manutencao'] ?? 0 ?></h4>
                            <p class="card-text">Manutenção</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-tools fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="btn-group" role="group">
                <a href="tables.php" class="btn <?= ($status_filter ?? 'all') === 'all' ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <i class="fas fa-list"></i> Todas
                </a>
                <a href="tables.php?status=disponivel" class="btn <?= ($status_filter ?? '') === 'disponivel' ? 'btn-success' : 'btn-outline-success' ?>">
                    <i class="fas fa-check-circle"></i> Disponíveis
                </a>
                <a href="tables.php?status=ocupada" class="btn <?= ($status_filter ?? '') === 'ocupada' ? 'btn-danger' : 'btn-outline-danger' ?>">
                    <i class="fas fa-users"></i> Ocupadas
                </a>
                <a href="tables.php?status=reservada" class="btn <?= ($status_filter ?? '') === 'reservada' ? 'btn-warning' : 'btn-outline-warning' ?>">
                    <i class="fas fa-calendar-alt"></i> Reservadas
                </a>
                <a href="tables.php?status=manutencao" class="btn <?= ($status_filter ?? '') === 'manutencao' ? 'btn-secondary' : 'btn-outline-secondary' ?>">
                    <i class="fas fa-tools"></i> Manutenção
                </a>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <a href="reservations.php" class="btn btn-info">
                <i class="fas fa-calendar-plus"></i> Gerenciar Reservas
            </a>
        </div>
    </div>

    <!-- Grid de mesas -->
    <div class="row">
        <?php if (empty($mesas ?? [])): ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-table fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Sistema de Mesas em Desenvolvimento</h4>
                        <p class="text-muted">Execute o script SQL para criar as tabelas necessárias</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Para ativar o sistema:</strong><br>
                            Use o importador web para criar as tabelas automaticamente
                        </div>
                        <div class="mt-3">
                            <a href="import_mesas_web.php" class="btn btn-success btn-lg">
                                <i class="fas fa-download"></i> Importar Sistema de Mesas
                            </a>
                            <a href="test_mesas.php" class="btn btn-outline-success ms-2">
                                <i class="fas fa-check-circle"></i> Testar Sistema
                            </a>
                            <a href="database.php" class="btn btn-outline-primary ms-2">
                                <i class="fas fa-database"></i> Administração BD
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($mesas as $mesa): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card table-card h-100 
                        <?php
                        switch ($mesa['status']) {
                            case 'disponivel':
                                echo 'border-success';
                                break;
                            case 'ocupada':
                                echo 'border-danger';
                                break;
                            case 'reservada':
                                echo 'border-warning';
                                break;
                            case 'manutencao':
                                echo 'border-secondary';
                                break;
                            default:
                                echo 'border-light';
                        }
                        ?>">
                        <div class="card-header 
                            <?php
                            switch ($mesa['status']) {
                                case 'disponivel':
                                    echo 'bg-success text-white';
                                    break;
                                case 'ocupada':
                                    echo 'bg-danger text-white';
                                    break;
                                case 'reservada':
                                    echo 'bg-warning text-dark';
                                    break;
                                case 'manutencao':
                                    echo 'bg-secondary text-white';
                                    break;
                                default:
                                    echo 'bg-light';
                            }
                            ?>">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-table"></i>
                                    Mesa <?= $mesa['numero_mesa'] ?>
                                </h5>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-users"></i> <?= $mesa['capacidade'] ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Status:</strong>
                                <span class="badge 
                                    <?php
                                    switch ($mesa['status']) {
                                        case 'disponivel':
                                            echo 'bg-success';
                                            break;
                                        case 'ocupada':
                                            echo 'bg-danger';
                                            break;
                                        case 'reservada':
                                            echo 'bg-warning text-dark';
                                            break;
                                        case 'manutencao':
                                            echo 'bg-secondary';
                                            break;
                                        default:
                                            echo 'bg-light text-dark';
                                    }
                                    ?>">
                                    <?= ucfirst($mesa['status']) ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <strong>Localização:</strong>
                                <span class="text-muted">
                                    <?= ucwords(str_replace('_', ' ', $mesa['localizacao'] ?? 'N/A')) ?>
                                </span>
                            </div>

                            <?php if (!empty($mesa['observacoes'])): ?>
                                <div class="mb-3">
                                    <strong>Observações:</strong>
                                    <p class="text-muted small mb-0"><?= htmlspecialchars($mesa['observacoes']) ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i>
                                    Atualizado: <?= date('d/m/Y H:i', strtotime($mesa['updated_at'] ?? $mesa['created_at'])) ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="updateTableStatus(<?= $mesa['id'] ?>, '<?= $mesa['numero_mesa'] ?>', '<?= $mesa['status'] ?>')">
                                    <i class="fas fa-edit"></i> Status
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info"
                                    onclick="viewTableDetails(<?= $mesa['id'] ?>)">
                                    <i class="fas fa-eye"></i> Detalhes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal para atualizar status da mesa -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Atualizar Status da Mesa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="tables.php/update-status" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="mesa_id" name="mesa_id">

                    <div class="mb-3">
                        <h6 id="mesa_titulo">Mesa #</h6>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Novo Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="disponivel">Disponível</option>
                            <option value="ocupada">Ocupada</option>
                            <option value="reservada">Reservada</option>
                            <option value="manutencao">Manutenção</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Observações sobre a mudança de status..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Atualizar Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .table-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .table-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-bottom: none;
    }

    .badge {
        font-size: 0.75em;
    }
</style>

<script>
    function updateTableStatus(mesaId, numeroMesa, statusAtual) {
        document.getElementById('mesa_id').value = mesaId;
        document.getElementById('mesa_titulo').textContent = 'Mesa ' + numeroMesa;
        document.getElementById('status').value = statusAtual;

        var modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
        modal.show();
    }

    function viewTableDetails(mesaId) {
        // Implementar visualização de detalhes da mesa
        alert('Funcionalidade de detalhes em desenvolvimento para Mesa ID: ' + mesaId);
    }

    // Auto-refresh da página a cada 30 segundos para manter status atualizado
    setInterval(function() {
        // Apenas refresh se não houver modais abertos
        if (!document.querySelector('.modal.show')) {
            location.reload();
        }
    }, 30000);
</script>