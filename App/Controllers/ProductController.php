<?php

namespace App\Controllers;

use app\core\request;
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
        $produtos->setFields('produtos.id, produtos.nome, produtos.descricao, produtos.preco, categorias.categoria as categoria_nome, produtos.ativo');
        $produtos->setFilters($filters);
        $produtosFound = $produtos->fetch_all();


        return $this->view('produtos', ['title' => 'Produtos', 'table' => $produtosFound]);
    }
    public function delete($parameters)
    {
        $parameters = intval($parameters[0]);
        $produto = new Products();
        $produto->delete('id', $parameters);
        header('location: /PHP-POO/routes-phpoo/public/products.php');
        exit;
    }
    public function edit($parameters)
    {
        $request = request::all();
        $parameters = intval($parameters[0]);
        $produto = new Products();
        $produto->update(['nome' => $request['name'], 'descricao' => $request['desc'], 'preco' => $request['preco'], 'ativo' => $request['prod_ativo']], "id={$parameters}");
        header('location: /PHP-POO/routes-phpoo/public/products.php');
        exit;
    }
}
