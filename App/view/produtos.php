<?php $this->layout('master', ['title' => $title, 'current_page' => 'Produtos']); ?>

<?= $_SERVER['PHP_SELF'] ?>

<section>
    <h1>Produtos</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($table as $produto): ?>
                <tr>
                    <td><?= $produto->id ?></td>
                    <td><?= $produto->nome ?></td>
                    <td><?= $produto->descricao ?></td>
                    <td><?= $produto->preco ?></td>
                    <td><?= $produto->categoria_nome ?></td>
                    <td>
                        <a href="#updatemodal<?= $produto->id ?>" data-toggle="modal" class="btn btn-primary" data-target="#updateModal<?= $produto->id ?>">Editar</a>
                        <a href="#deleteModal<?= $produto->id ?>" data-toggle="modal" class="btn btn-danger" data-target="#deleteModal<?= $produto->id ?>">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
</section>

<!-- Modal Atualizar -->
<?php foreach ($table as $produto): ?>
    <div class="modal fade" id="updateModal<?= $produto->id ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-muted" id="updateModalLabel">Atualizar Produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="produtos.php/edit/<?= $produto->id ?>" method="post">
                        <div class="form-group">
                            <label for="name<?= $produto->id ?>">Nome</label>
                            <input type="text" class="form-control" id="name<?= $produto->id ?>" name="name" value="<?= $produto->nome ?>">
                            <label for="desc<?= $produto->id ?>">Descrição</label>
                            <input type="text" class="form-control" id="desc<?= $produto->id ?>" name="desc" value="<?= $produto->descricao ?>">
                            <label for="preco<?= $produto->id ?>">Preço</label>
                            <input type="number" class="form-control" id="preco<?= $produto->id ?>" name="preco" value="<?= $produto->preco ?>">
                            <label for="prod_ativo<?= $produto->id ?>">Ativo</label>
                            <select class="form-control" id="prod_ativo<?= $produto->id ?>" name="prod_ativo">
                                <option value="1" <?php echo ($produto->ativo == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                                <option value="0" <?php echo ($produto->ativo == 'desativado') ? 'selected' : ''; ?>>Desativado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Deletar -->
<?php foreach ($table as $produto): ?>
    <div class="modal fade" id="deleteModal<?= $produto->id ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                <form action="produtos.php/delete/<?= $produto->id ?>" method="post">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-danger" type="submit">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>