<?php
require_once 'app/Model/ProdutoModel.php';
class ProdutoController 
{
    private $pdo;
    private $produtoModel;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->produtoModel = new ProdutoModel($this->pdo);
    }
    public function listarProdutos($id)
    {
        $produtos = $this->produtoModel->buscar($id);
        // var_dump($produtos);        
        return json_encode($produtos);
    }

    public function atualizarProduto($id, $nome, $preco_custo, $preco_venda)
    {   
        $resultado = $this->produtoModel->atualizarProduto($id, $nome , $preco_custo, $preco_venda);
        return $resultado;
    }

    public function criarProduto($nome, $preco_custo, $preco_venda, $tipo_produto_id)
    {
        $resultado = $this->produtoModel->criarProduto($nome, $preco_custo, $preco_venda, $tipo_produto_id);
        return $resultado;
    }

    public function deletarProduto($id){
        $resultado = $this->produtoModel->deletarProduto($id);
        return $resultado;
    }
}
