<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm custom-navbar modern-navbar"
    style="backdrop-filter: blur(8px); background: rgba(40,40,60,0.95); min-height: 56px;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="/PHP-POO/routes-phpoo/public/">
            <i class="fas fa-leaf fa-lg me-2"></i>
            <span class="fw-bold">Meu Sistema</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link<?= ($page == 'index.php') ? ' active' : '' ?>"
                        href="index.php"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link<?= ($page == 'tables.php') ? ' active' : '' ?>"
                        href="tables.php"><i class="fas fa-utensils me-1"></i> Mesas</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?= ($page == 'products.php') ? ' active' : '' ?>" href="#"
                        id="produtosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-box me-1"></i> Produtos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="produtosDropdown">
                        <li><a class="dropdown-item" href="products.php"><i class="fas fa-list me-1"></i> Listar
                                Produtos</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-plus me-1"></i> Adicionar Produto</a>
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-tags me-1"></i> Categorias</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-warehouse me-1"></i> Estoque</a></li>
                    </ul>
                </li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['cargo'] === 'ADMINISTRADOR'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?= ($page == 'user.php') ? ' active' : '' ?>" href="#"
                            id="usuariosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-users me-1"></i> Usuários
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="usuariosDropdown">
                            <li><a class="dropdown-item" href="user.php"><i class="fas fa-list me-1"></i> Listar
                                    Usuários</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-plus me-1"></i> Adicionar
                                    Usuário</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-shield-alt me-1"></i> Permissões</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-users-cog me-1"></i> Grupos</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link<?= ($page == 'chat_teste.php') ? ' active' : '' ?>"
                        href="chat_teste.php"><i class="fas fa-comments me-1"></i> Chat</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="relatoriosDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-chart-bar me-1"></i> Relatórios
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="relatoriosDropdown">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-1"></i> Vendas</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-warehouse me-1"></i> Estoque</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-users me-1"></i> Usuários</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-dollar-sign me-1"></i> Financeiro</a>
                        </li>
                    </ul>
                </li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['cargo'] === 'ADMINISTRADOR'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="configDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cog me-1"></i> Configurações
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="configDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-tools me-1"></i> Sistema</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-database me-1"></i> Backup</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-alt me-1"></i> Logs</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-wrench me-1"></i> Manutenção</a></li>
                            <li><a class="dropdown-item" href="database"><i class="fas fa-database me-1"></i> Database</a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <?php if (isset($_SESSION['user'])): ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span
                                class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                style="width:36px;height:36px;font-size:1.1rem;">
                                <?= strtoupper(substr($_SESSION['user']['username'], 0, 2)) ?>
                            </span>
                            <span
                                class="d-none d-lg-inline fw-semibold"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li class="px-3 py-2">
                                <div class="fw-bold"><?= htmlspecialchars($_SESSION['user']['username']) ?></div>
                                <div class="text-muted small"><?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="user.php"><i class="fas fa-user-cog me-2"></i> Perfil</a>
                            </li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i
                                        class="fas fa-sign-out-alt me-2"></i> Sair</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>