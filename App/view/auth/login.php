<?php $this->layout('master', ['title' => $title, 'current_page' => 'Login', 'page' => 'login.php']); ?>

<section class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Login</h3>
                </div>
                <div class="card-body">
                    <form action="/PHP-POO/routes-phpoo/public/login.php" method="post">
                        <div class="form-group mb-3">
                            <label for="email">Email ou Usuário</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>