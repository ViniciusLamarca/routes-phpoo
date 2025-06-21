<?php $this->layout('master', ['title' => $title, 'current_page' => 'Pagina Inicial', 'page' => 'index.php']); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h1 class="mb-0">
                        <i class="fas fa-home text-primary"></i>
                        Bem-vindo ao Sistema
                    </h1>
                </div>
                <div class="card-body">
                    <?php if (isset($user)): ?>
                        <div class="alert alert-info">
                            <h4><i class="fas fa-user-circle"></i> Olá, <?php echo htmlspecialchars($user['username']); ?>!
                            </h4>
                            <p class="mb-0">Você está logado como
                                <strong><?php echo htmlspecialchars($user['cargo'] ?? 'Usuário'); ?></strong>
                            </p>
                        </div>
                    <?php endif; ?>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center d-flex flex-column">
                                    <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                                    <h5>Dashboard</h5>
                                    <p>Visualize estatísticas e métricas do sistema</p>
                                    <a href="#" class="btn btn-primary btn-sm mt-auto">Acessar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center d-flex flex-column">
                                    <i class="fas fa-cog fa-3x text-primary mb-3"></i>
                                    <h5>Configurações</h5>
                                    <p>Gerencie as configurações do sistema</p>
                                    <a href="#" class="btn btn-primary btn-sm mt-auto">Configurar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i>
                        Sobre o Sistema
                    </h5>
                </div>
                <div class="card-body">
                    <p>Este é um sistema desenvolvido em PHP orientado a objetos com arquitetura MVC moderna. Oferece
                        funcionalidades completas para gerenciamento de usuários, produtos e comunicação em tempo real.
                    </p>

                    <h6 class="mt-4">Características:</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Arquitetura MVC</li>
                        <li><i class="fas fa-check text-success"></i> Sistema de autenticação</li>
                        <li><i class="fas fa-check text-success"></i> Chat em tempo real</li>
                        <li><i class="fas fa-check text-success"></i> Interface responsiva</li>
                        <li><i class="fas fa-check text-success"></i> Design moderno</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-clock"></i>
                        Acesso Rápido
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="products.php" class="list-group-item list-group-item-action border-0">
                            <i class="fas fa-box"></i> Produtos
                        </a>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['cargo'] === 'ADMINISTRADOR'): ?>
                            <a href="user.php" class="list-group-item list-group-item-action border-0">
                                <i class="fas fa-users"></i> Usuários
                            </a>
                        <?php endif; ?>
                        <a href="chat_teste.php" class="list-group-item list-group-item-action border-0">
                            <i class="fas fa-comments"></i> Chat
                        </a>
                        <a href="logout.php" class="list-group-item list-group-item-action border-0 text-danger">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>