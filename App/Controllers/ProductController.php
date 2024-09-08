<?php

namespace App\Controllers;

use app\dataBase\Models\Products;
use app\dataBase\Filters;
use app\controllers\Controller;


class ProductController extends Controller
{
    public function index()
    {

        $filters = new Filters();
        $filters->join('categorias', 'produtos.categoria_id', '=', 'categorias.id', 'LEFT JOIN');

        $produtos = new Products();
        $produtos->setFields('produtos.id, produtos.nome, produtos.descricao, produtos.preco, categorias.categoria as categoria_nome');
        $produtos->setFilters($filters);
        $produtosFound = $produtos->fetch_all();


        $this->view('produtos', ['title' => 'Produtos', 'table' => $produtosFound]);
    }
    public function delete($parameters)
    {
        $parameters = intval($parameters[0]);
        $produto = new Products();
        $produto->delete('id', $parameters);
        header('location: http://localhost/PHP-POO/public/products.php');
        exit;
    }
}
