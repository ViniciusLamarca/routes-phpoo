<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm custom-navbar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <a class="navbar-brand" href="/PHP-POO/routes-phpoo/public/">
        <i class="fas fa-leaf"></i> Meu Sistema
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
            <li class="nav-item <?php echo ($page == 'index.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="index.php">Início</a>
            </li>
            <li class="nav-item <?php echo ($page == 'products.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="products.php">Produtos</a>
            </li>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['cargo'] === 'ADMINISTRADOR'): ?>
                <li class="nav-item <?php echo ($page == 'user.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="user.php">Usuários</a>
                </li>
            <?php endif; ?>
            <li class="nav-item <?php echo ($page == 'chat_teste.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="chat_teste.php">Chat</a>
            </li>
        </ul>
        <?php if (isset($_SESSION['user'])): ?>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="user.php">
                            <i class="fas fa-user-cog"></i> Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </a>
                    </div>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</nav>