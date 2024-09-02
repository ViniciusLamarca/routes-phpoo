<?php

namespace App\Controllers;

use app\dataBase\Models\Products;
use app\dataBase\Filters;
use app\controllers\Controller;


class ProductController extends Controller
{
    public function show()
    {

        $filters = new Filters();
        $filters->join('categorias', 'produtos.categoria_id', '=', 'categorias.id', 'LEFT JOIN');

        $produtos = new Products();
        $produtos->setFields('produtos.id, produtos.nome, produtos.descricao, produtos.preco, categorias.categoria as categoria_nome');
        $produtos->setFilters($filters);
        $produtosFound = $produtos->fetch_all();
        dd($produtosFound);
    }
}
