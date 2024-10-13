<?php

namespace app\core;

class Folha
{
    public $valor;
    public $esquerdo;
    public $direito;

    public function __construct($valor)
    {
        $this->valor = $valor;
        $this->esquerdo = null;
        $this->direito = null;
    }
}

class Arvore
{
    public $raiz;

    public function __construct()
    {
        $this->raiz = null;
    }

    public function inserir($valor)
    {
        $novaFolha = new Folha($valor);
        if ($this->raiz === null) {
            $this->raiz = $novaFolha;
        } else {
            $this->inserirFolha($this->raiz, $novaFolha);
        }
    }

    private function inserirFolha($folha, $novaFolha)
    {
        if ($novaFolha->valor < $folha->valor) {
            if ($folha->esquerdo === null) {
                $folha->esquerdo = $novaFolha;
            } else {
                $this->inserirFolha($folha->esquerdo, $novaFolha);
            }
        } else {
            if ($folha->direito === null) {
                $folha->direito = $novaFolha;
            } else {
                $this->inserirFolha($folha->direito, $novaFolha);
            }
        }
    }

    public function ArvoreEmOrdem($folha)
    {
        if ($folha !== null) {
            $this->ArvoreEmOrdem($folha->esquerdo);
            echo $folha->valor . "\n";
            $this->ArvoreEmOrdem($folha->direito);
        }
    }

    public function MostrarArvore($folha)
    {
        if ($folha !== null) {
            echo $folha->valor . "\n";
            $this->MostrarArvore($folha->esquerdo);
            $this->MostrarArvore($folha->direito);
        }
    }
}
