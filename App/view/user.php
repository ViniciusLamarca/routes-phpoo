<?php $this->layout('master', ['title' => $title, 'current_page' => 'Usuário']); ?>



<section>
    <h1>User Profile</h1>
    <table class="table table-striped">
        <div class="d-flex justify-content-end align-items-center">
            <a href="register.php" class="btn btn-primary">Novo</a>
        </div>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo de usuário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($table as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->nome ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->tipo_user ?></td>
                    <td>
                        <a href="user.php/edit/<?= $user->id ?>" class="btn btn-primary">Editar</a>
                        <a href="user.php/delete/<?= $user->id ?>" class="btn btn-danger">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>