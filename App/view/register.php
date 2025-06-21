<?php $this->layout('guest', ['title' => $title, 'current_page' => 'Register', 'page' => 'register.php']); ?>

<div class="card">
    <div class="card-header">
        <h3 class="text-center mb-0">
            <i class="fas fa-user-plus text-primary"></i>
            Cadastro
        </h3>
        <p class="text-muted text-center mt-2 mb-0">Crie sua conta no sistema</p>
    </div>
    <div class="card-body">
        <form action="/PHP-POO/routes-phpoo/public/register.php" method="post">
            <div class="form-group mb-3">
                <label for="name" class="form-label">
                    <i class="fas fa-user"></i> Nome
                </label>
                <input type="text" class="form-control" id="name" name="name" required
                    placeholder="Digite seu nome completo">
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" class="form-control" id="email" name="email" required
                    placeholder="Digite seu email">
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Senha
                </label>
                <input type="password" class="form-control" id="password" name="password" required
                    placeholder="Digite sua senha">
            </div>
            <div class="form-group mb-4">
                <label for="tipo_user" class="form-label">
                    <i class="fas fa-user-tag"></i> Tipo de usuário
                </label>
                <select class="form-control" id="tipo_user" name="tipo_user" required>
                    <option value="">Selecione o tipo</option>
                    <option value="ADMINISTRADOR">Administrador</option>
                    <option value="USER">Usuário</option>
                </select>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Cadastrar
                </button>
            </div>
        </form>
    </div>
</div>