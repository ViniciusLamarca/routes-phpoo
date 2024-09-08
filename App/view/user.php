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
                        <!-- Modal Editar -->
                        <a href="#updateModal<?= $user->id ?>" data-toggle="modal" class="btn btn-primary" data-target="#updateModal<?= $user->id ?>">Editar</a>

                        <!-- Modal Deletar -->
                        <a href="#deleteModal<?= $user->id ?>" data-toggle="modal" class="btn btn-danger" data-target="#deleteModal<?= $user->id ?>">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</section>



<!-- Modal Deletar -->
<?php foreach ($table as $user): ?>
    <div class="modal fade" id="deleteModal<?= $user->id ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-muted" id="deleteModalLabel">Confirmação de Exclusão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Você está prestes a excluir um registro. Esta ação não pode ser desfeita. Deseja continuar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="user.php/delete/<?= $user->id ?>" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Atualizar -->
<?php foreach ($table as $user): ?>
    <div class="modal fade" id="updateModal<?= $user->id ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-muted" id="updateModalLabel">Atualizar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>/edit/id=<?= $user->id ?>" method="post">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user->nome ?>">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $user->email ?>">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="password">
                            <label for="tipo_user">Tipo de usuário</label>
                            <select class="form-control" id="tipo_user" name="tipo_user">
                                <option value="ADMINISTRADOR" <?php echo ($user->tipo_user == 'ADMINISTRADOR') ? 'selected' : ''; ?>>Administrador</option>
                                <option value="USER" <?php echo ($user->tipo_user == 'USER') ? 'selected' : ''; ?>>Usuário</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Enviar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>