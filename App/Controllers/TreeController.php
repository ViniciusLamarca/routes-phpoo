<?php

namespace App\Controllers;


use app\controllers\Controller;
use app\core\Arvore as CoreArvore;



class TreeController extends Controller
{
    //função de teste para preencher um array aleatoriamente
    private function preencherArrayComAleatorios($tamanho, $min, $max)
    {
        $array = [];

        for ($i = 0; $i < $tamanho; $i++) {
            $array[] = mt_rand($min, $max);
        }

        return $array;
    }

    public function index()
    {
        $arvore = new CoreArvore();
        $valores = $this->preencherArrayComAleatorios(10, 0, 100);
        foreach ($valores as $valor) {
            $arvore->inserir($valor);
        }
        $arvore->ArvoreEmOrdem($arvore->raiz);

        $this->view('tree_view', ['title' => 'Árvores', 'page' => 'arvores.php', 'arvore' => $arvore]);
    }
}
