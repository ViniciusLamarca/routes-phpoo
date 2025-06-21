<?php $this->layout('master', ['title' => $title]) ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php $this->insert('partials/sidebar') ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?= $this->e($page_title) ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Compartilhar</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Exportar</button>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <?php $this->insert('partials/notifications') ?>

            <!-- Dashboard Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Usuários Ativos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">1,234</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Produtos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">456</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Mensagens
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">789</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pedidos Pendentes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Visão Geral</h6>
                        </div>
                        <div class="card-body">
                            <p>Bem-vindo(a), <strong><?= $this->e($user['username'] ?? 'Usuário') ?></strong>!</p>
                            <p>Este é o painel de controle do sistema. Aqui você pode gerenciar:</p>
                            <ul>
                                <li><a href="/user.php">Usuários</a></li>
                                <li><a href="/products.php">Produtos</a></li>
                                <li><a href="/chat_teste.php">Chat</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Ações Rápidas</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="/user.php" class="btn btn-primary btn-sm">
                                    <i class="fas fa-users"></i> Gerenciar Usuários
                                </a>
                                <a href="/products.php" class="btn btn-success btn-sm">
                                    <i class="fas fa-box"></i> Gerenciar Produtos
                                </a>
                                <a href="/chat_teste.php" class="btn btn-info btn-sm">
                                    <i class="fas fa-comments"></i> Chat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>