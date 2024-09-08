<?php $this->layout('master', ['title' => $title, 'current_page' => 'Produtos']); ?>


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
                        <a href="produtos.php/edit/<?= $produto->id ?>" class="btn btn-primary">Editar</a>
                        <a href="#deleteModal" data-toggle="modal" class="btn btn-danger" data-target="#deleteModal">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
</section>



<!-- delete question modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                <a href="produtos.php/delete/<?= $produto->id ?>" class="btn btn-danger">Excluir</a>
            </div>
        </div>
    </div>
</div>