<?php
require_once 'Connection.php';
class ProdutoModel 
{
    private $pdo;
    private $id;
    private $nome;
    private $descricao;
    private $preco;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscar($id = null)
    {   
        if ($id === null) {
            $stmt = $this->pdo->query('SELECT * FROM produtos');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->pdo->prepare('SELECT * FROM produtos WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function atualizarProduto(int $id, string $nome , float $preco_custo, float $preco_venda): bool
    {   
        $stmt = $this->pdo->prepare('UPDATE produtos SET nome = :nome, preco_custo= :preco_custo, preco_venda= :preco_venda WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':preco_custo', $preco_custo, PDO::PARAM_INT);
        $stmt->bindParam(':preco_venda', $preco_venda, PDO::PARAM_INT);
        try{
            $stmt->execute();
            return true;
        }catch(PDOException $e){
            echo "Erro ao executar UPDATE: ". $e->getMessage();
            return false;
        }
    }

    public function criarProduto($nome, $preco_custo, $preco_venda, $tipo_produto_id): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO produtos (nome, preco_custo, preco_venda, tipo_produto_id) VALUES (:nome, :preco_custo, :preco_venda, :tipo_produto_id)');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':preco_custo', $preco_custo, PDO::PARAM_INT);
        $stmt->bindParam(':preco_venda', $preco_venda, PDO::PARAM_INT);
        $stmt->bindParam(':tipo_produto_id', $tipo_produto_id, PDO::PARAM_STR);
        
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erro ao executar INSERT: " . $e->getMessage();
            return false;
        }
    }

    public function deletarProduto(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM produtos WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erro ao executar DELETE: " . $e->getMessage();
            return false;
        }
    }
}
