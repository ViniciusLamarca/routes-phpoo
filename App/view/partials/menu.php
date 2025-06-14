<nav class="navbar navbar-expand-lg navbar-dark bg-dark flex-column flex-md-row sticky-top">
    <a class="navbar-brand custom-width" href="index.php"><?= $this->e($page_title) ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo ($page == 'index.php') ? 'active' : ''; ?>" href="index.php">
                    Início
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($page == 'products.php') ? 'active' : ''; ?>" href="products.php">
                    Produtos
                </a>
            </li>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['cargo'] === 'ADMINISTRADOR'): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page == 'user.php') ? 'active' : ''; ?>" href="user.php">
                        Usuários
                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($page == 'chat_teste.php') ? 'active' : ''; ?>" href="chat_teste.php">
                    Chat
                </a>
            </li>
        </ul>
        <?php if (isset($_SESSION['user'])): ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
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