<?php $this->layout('master', ['title' => $title]) ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="display-1 text-muted">404</h1>
            <h2>Oops! Página não encontrada</h2>
            <p class="lead"><?= $message ?></p>
            <a href="/PHP-POO/routes-phpoo/public/" class="btn btn-primary">
                <i class="fas fa-home"></i> Voltar ao Início
            </a>
        </div>
    </div>
</div>