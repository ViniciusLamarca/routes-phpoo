<?php $this->layout('master', ['title' => $title, 'current_page' => $current_page, 'page' => $page]); ?>

<div class="container-fluid">
    <!-- Header da página -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-calendar-alt text-primary"></i>
                Reservas
            </h2>
            <p class="text-muted mb-0">Gerencie reservas e disponibilidade das mesas</p>
        </div>
        <div>
            <a href="tables.php" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left"></i> Voltar às Mesas
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newReservationModal">
                <i class="fas fa-plus"></i> Nova Reserva
            </button>
        </div>
    </div>

    <!-- Filtros de data -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-filter"></i> Filtros
                    </h6>
                    <form method="GET" action="reservations.php" class="row g-3">
                        <div class="col-md-6">
                            <label for="data_inicio" class="form-label">Data Início</label>
                            <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                                value="<?= $_GET['data_inicio'] ?? date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="data_fim" class="form-label">Data Fim</label>
                            <input type="date" class="form-control" id="data_fim" name="data_fim"
                                value="<?= $_GET['data_fim'] ?? date('Y-m-d', strtotime('+7 days')) ?>">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            <a href="reservations.php" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Limpar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle"></i> Resumo
                    </h6>
                    <p class="mb-1">
                        <strong><?= count($reservas ?? []) ?></strong> reservas encontradas
                    </p>
                    <p class="mb-0">
                        <strong><?= count($mesas_disponiveis ?? []) ?></strong> mesas disponíveis
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de reservas -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-list"></i> Reservas Ativas
            </h5>
        </div>
        <div class="card-body">
            <?php if (empty($reservas)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Nenhuma reserva encontrada</h4>
                    <p class="text-muted">Não há reservas para o período selecionado</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newReservationModal">
                        <i class="fas fa-plus"></i> Criar Primera Reserva
                    </button>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mesa</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Pessoas</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservas as $reserva): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">
                                            Mesa <?= $reserva['numero_mesa'] ?>
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            Cap: <?= $reserva['capacidade'] ?> pessoas
                                        </small>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($reserva['cliente_nome']) ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-phone"></i>
                                            <?= htmlspecialchars($reserva['cliente_telefone']) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?>
                                        <br>
                                        <small class="text-muted">
                                            <?= date('l', strtotime($reserva['data_reserva'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <strong><?= $reserva['hora_reserva'] ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?= $reserva['numero_pessoas'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            <?php
                                            switch ($reserva['status']) {
                                                case 'ativa':
                                                    echo 'bg-success';
                                                    break;
                                                case 'confirmada':
                                                    echo 'bg-primary';
                                                    break;
                                                case 'cancelada':
                                                    echo 'bg-danger';
                                                    break;
                                                default:
                                                    echo 'bg-secondary';
                                            }
                                            ?>">
                                            <?= ucfirst($reserva['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                onclick="editReservation(<?= $reserva['id'] ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="cancelReservation(<?= $reserva['id'] ?>)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
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

<!-- Modal para nova reserva -->
<div class="modal fade" id="newReservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus"></i> Nova Reserva
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="reservations.php/create" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mesa_id" class="form-label">Mesa</label>
                                <select class="form-control" id="mesa_id" name="mesa_id" required>
                                    <option value="">Selecione uma mesa</option>
                                    <?php foreach ($mesas_disponiveis ?? [] as $mesa): ?>
                                        <option value="<?= $mesa['id'] ?>">
                                            Mesa <?= $mesa['numero_mesa'] ?> (<?= $mesa['capacidade'] ?> pessoas)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="numero_pessoas" class="form-label">Número de Pessoas</label>
                                <input type="number" class="form-control" id="numero_pessoas" name="numero_pessoas"
                                    required min="1" max="20" value="2">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="data_reserva" class="form-label">Data da Reserva</label>
                                <input type="date" class="form-control" id="data_reserva" name="data_reserva" required
                                    min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hora_reserva" class="form-label">Horário</label>
                                <select class="form-control" id="hora_reserva" name="hora_reserva" required>
                                    <option value="">Selecione o horário</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:30">11:30</option>
                                    <option value="12:00">12:00</option>
                                    <option value="12:30">12:30</option>
                                    <option value="13:00">13:00</option>
                                    <option value="13:30">13:30</option>
                                    <option value="19:00">19:00</option>
                                    <option value="19:30">19:30</option>
                                    <option value="20:00">20:00</option>
                                    <option value="20:30">20:30</option>
                                    <option value="21:00">21:00</option>
                                    <option value="21:30">21:30</option>
                                    <option value="22:00">22:00</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cliente_nome" class="form-label">Nome do Cliente</label>
                                <input type="text" class="form-control" id="cliente_nome" name="cliente_nome" required
                                    maxlength="100" placeholder="Nome completo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cliente_telefone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="cliente_telefone" name="cliente_telefone"
                                    required placeholder="(00) 00000-0000">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observacoes_reserva" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes_reserva" name="observacoes" rows="3"
                            placeholder="Observações especiais, preferências, etc."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Criar Reserva
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editReservation(reservaId) {
        // Implementar edição de reserva
        alert('Edição de reserva em desenvolvimento para ID: ' + reservaId);
    }

    function cancelReservation(reservaId) {
        if (confirm('Tem certeza que deseja cancelar esta reserva?')) {
            // Implementar cancelamento
            alert('Cancelamento em desenvolvimento para ID: ' + reservaId);
        }
    }

    // Aplicar máscara no telefone
    document.getElementById('cliente_telefone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            e.target.value = value;
        }
    });
</script>