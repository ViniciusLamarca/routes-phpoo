<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm custom-navbar modern-navbar"
    style="backdrop-filter: blur(8px); background: rgba(40,40,60,0.95); min-height: 56px;">
    <div class="container px-4">
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
            <ul class="navbar-nav ms-auto me-3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 profile-menu-btn"
                        href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        style="min-height:56px; border-radius: 2rem; background: rgba(102,126,234,0.10); transition: background 0.2s; min-width: 170px; max-width: 100vw;">
                        <span class="profile-avatar d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width:48px; height:48px; min-width:48px; min-height:48px; border-radius:50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color:#fff; font-size:1.35rem; font-weight:600; box-shadow:0 2px 8px rgba(102,126,234,0.18);">
                            <?= strtoupper(substr($_SESSION['user']['username'] ?? 'US', 0, 2)) ?>
                        </span>
                        <span class="fw-semibold profile-username flex-shrink-1"
                            style="font-size:1.15rem; color:#fff; white-space:nowrap; padding-left:10px; overflow:hidden; text-overflow:ellipsis;">
                            <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Usuário') ?>
                        </span>
                        <i class="fas fa-chevron-down ms-2" style="font-size:1rem; color:#888;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="userDropdown"
                        style="min-width:220px; border-radius:1rem;">
                        <li class="px-3 py-3 text-center">
                            <span class="profile-avatar d-inline-flex align-items-center justify-content-center mb-2"
                                style="width:56px; height:56px; border-radius:50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color:#fff; font-size:1.5rem; font-weight:600; box-shadow:0 2px 8px rgba(102,126,234,0.18);">
                                <?= strtoupper(substr($_SESSION['user']['username'] ?? 'US', 0, 2)) ?>
                            </span>
                            <div class="fw-bold mt-1" style="font-size:1.1rem;">
                                <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Usuário') ?>
                            </div>
                            <div class="text-muted small" style="font-size:0.95rem;">
                                <?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item py-2" href="user.php"><i class="fas fa-user-cog me-2"></i>
                                Perfil</a></li>
                        <li><a class="dropdown-item text-danger py-2" href="logout.php"><i
                                    class="fas fa-sign-out-alt me-2"></i> Sair</a></li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>