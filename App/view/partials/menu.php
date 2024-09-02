<nav class="navbar navbar-expand-lg navbar-dark bg-dark flex-column flex-md-row sticky-top">
    <a class="navbar-brand custom-width" href="index.php"><?= $this->e($page_title) ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">
                    HomePage
                </a>
            </li class="nav-item">
            <li>
                <a class="nav-link <?php echo ($current_page == 'products.php') ? 'active' : ''; ?>" href="products.php">
                    Produtos
                </a>
            </li class="nav-item">
            <li>
                <a class="nav-link <?php echo ($current_page == 'user.php') ? 'active' : ''; ?>" href="user.php">
                    Usuário
                </a>
            </li>
        </ul>
</nav>