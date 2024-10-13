<?php $this->layout('master', ['title' => $title, 'current_page' => 'Arvores', 'page' => 'arvores.php']); ?>



<section>
    <h1>Árvores</h1>
    <div>
        <h2>Árvore desordenada</h2>
        <?php $arvore->MostrarArvore($arvore->raiz); ?>
    </div>
    <div>
        <h2>Árvore em ordem</h2>
        <?php $arvore->ArvoreEmOrdem($arvore->raiz); ?>
    </div>
</section>