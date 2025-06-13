<?php $this->layout('master', ['title' => $title, 'current_page' => 'Pagina Inicial', 'page' => 'index.php']); ?>

<section>
    <h1>Home</h1>
    <?php if (isset($user)): ?>
        <div class="alert alert-success">
            Bem-vindo, <?php echo htmlspecialchars($user['username']); ?>!
            <a href="/PHP-POO/routes-phpoo/public/logout.php" class="btn btn-danger btn-sm float-end">Sair</a>
        </div>
    <?php endif; ?>
    <p>This is the home page</p>
    <article>
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda architecto natus nihil. Explicabo accusantium, quibusdam eos cupiditate veritatis nobis perferendis odit odio repellendus laborum in sapiente sint voluptate eaque deserunt!
    </article>
</section>