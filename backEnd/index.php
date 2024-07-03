<?php

require 'vendor/autoload.php';
require 'app/Core/core.php';
$pdo = require 'Connection.php';
require 'app/Controller/ProdutoController.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

handleCors();

$path = $_SERVER['REQUEST_URI'];

if($path == '/listarProdutos') {
    $produtoController = new ProdutoController($pdo);
    header('Content-Type: application/json');    
    $resultado = $produtoController->listarProdutos($id = null);    
    echo json_encode($resultado);
}

if($path === '/salvarProduto') {
    $produtoController = new ProdutoController($pdo);
    header('Content-Type: application/json');
    $postData = file_get_contents("php://input");
    $data = json_decode($postData);

    $nome = $data->nome;
    $preco_custo = $data->preco_custo;
    $preco_venda = $data->preco_venda;
    $tipo_produto_id = $data->tipo_produto_id;

    $produtoController->criarProduto($nome, $preco_custo, $preco_venda, $tipo_produto_id);
    echo 'Produto salvo com sucesso!';
}

if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $parts = explode('/', $path);
    $id = end($parts);
    if($path === '/deletarProduto/'.$id) {
        $produtoController = new ProdutoController($pdo);
        $produtoController->deletarProduto($id);
        echo 'Excluido com sucesso';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {    
    $produtoController = new ProdutoController($pdo);
    $parts = explode('/', $path);
    $id = end($parts);
    if($path === '/atualizarProduto/'.$id) {        
        $data = json_decode(file_get_contents("php://input"));
        $produtoController->atualizarProduto($id, $data->nome, $data->preco_custo, $data->preco_venda);
    }
}

// $routes = [
//     '/salvarProduto' => 'index.php',
//     '/listarProdutos' => 'index.php',
//     '/delete' => 'app/Template/contato.html'
// ];

// if (array_key_exists($path, $routes)) {
    // $route = $routes[$path];
    
    // if ($route === 'index.php') {
    //     $produtoController = new ProdutoController($pdo);

    //     if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //         $id = isset($_GET['id']) ? $_GET['id'] : null;
    //         header('Content-Type: application/json');
    //         $produtoController->listarProdutos($id);
            
    //     } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    //         $produtoController->atualizarProduto($id, $nome, $preco_custo, $preco_venda);

    //     } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $postData = file_get_contents("php://input");
    //         $data = json_decode($postData);

    //         $nome = $data->nome;
    //         $preco_custo = $data->preco_custo;
    //         $preco_venda = $data->preco_venda;
    //         $tipo_produto_id = $data->tipo_produto_id;

    //         $produtoController->criarProduto($nome, $preco_custo, $preco_venda, $tipo_produto_id);
    //     } else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //         $produtoController->deletarProduto($id);
    //     }
    //     else {
    //         header("HTTP/1.1 405 Method Not Allowed");
    //     }
    // } else {
    //     include $route;
    // }
// } else {
//     header("HTTP/1.1 404 Not Found");
//     include 'app/Template/404.html';
// }
