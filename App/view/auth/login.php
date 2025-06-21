<?php $this->layout('guest', ['title' => $title ?? 'Login', 'current_page' => 'Login', 'page' => 'login.php']); ?>

<div class="card">
    <div class="card-header">
        <h3 class="text-center mb-0">
            <i class="fas fa-sign-in-alt text-primary"></i>
            Login
        </h3>
        <p class="text-muted text-center mt-2 mb-0">Entre com suas credenciais</p>
    </div>
    <div class="card-body">
        <form action="/PHP-POO/routes-phpoo/public/authenticate" method="post" id="loginForm">
            <div class="form-group mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Email ou Usuário
                </label>
                <input type="text" class="form-control" id="email" name="email" required
                    placeholder="Digite seu email ou usuário"
                    value="<?= htmlspecialchars($old_input['email'] ?? '') ?>">
            </div>
            <div class="form-group mb-4">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Senha
                </label>
                <input type="password" class="form-control" id="password" name="password" required
                    placeholder="Digite sua senha">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary" id="loginBtn">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Adicionar feedback visual ao formulário
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('loginBtn');
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Entrando...';
        btn.disabled = true;

        // Se houver erro na validação, restaurar o botão
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 5000);
    });

    // Limpar notificações antigas quando começar a digitar
    document.getElementById('email').addEventListener('input', function() {
        // Limpar notificações de erro existentes
        const notifications = document.querySelectorAll('.notification-float[data-type="error"]');
        notifications.forEach(notification => {
            notification.remove();
        });
    });

    document.getElementById('password').addEventListener('input', function() {
        // Limpar notificações de erro existentes
        const notifications = document.querySelectorAll('.notification-float[data-type="error"]');
        notifications.forEach(notification => {
            notification.remove();
        });
    });
</script>