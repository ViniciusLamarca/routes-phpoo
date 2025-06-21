<?php $this->layout('guest', ['title' => $title, 'current_page' => 'Login', 'page' => 'login.php']); ?>

<div class="card">
    <div class="card-header">
        <h3 class="text-center mb-0">
            <i class="fas fa-sign-in-alt text-primary"></i>
            Login
        </h3>
        <p class="text-muted text-center mt-2 mb-0">Entre com suas credenciais</p>
    </div>
    <div class="card-body">
        <form action="/PHP-POO/routes-phpoo/public/login.php" method="post">
            <div class="form-group mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Email ou Usuário
                </label>
                <input type="text" class="form-control" id="email" name="email" required
                    placeholder="Digite seu email ou usuário">
            </div>
            <div class="form-group mb-4">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Senha
                </label>
                <input type="password" class="form-control" id="password" name="password" required
                    placeholder="Digite sua senha">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>
            </div>
        </form>
    </div>
</div>