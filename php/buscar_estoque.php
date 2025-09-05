<?php
require_once "conexao.php";

try {
    $sql = "SELECT id_produto, nome_produto, quantidade_produto 
            FROM produto 
            ORDER BY nome_produto ASC";
    $stmt = $pdo->query($sql);
    $produtosEstoque = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar estoque: " . $e->getMessage();
    $produtosEstoque = [];
}
?>