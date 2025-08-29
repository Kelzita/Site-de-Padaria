<?php
session_start();
require_once 'conexao.php';

/*if($_SESSION['id_funcao'] != 1 && $_SESSION['id_funcao'] != 2) {
    echo "<script>alert('Acesso Negado!');window.location.href='../principal.php';</script>";
}*/

$produtos = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);

    if (is_numeric($busca)) {
        $sql = "SELECT id_produto, id_fornecedor, nome_produto, descricao, preco, unmedida, validade, imagem_produto, quantidade_produto
                FROM produto
                WHERE id_produto = :busca
                ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT id_produto, id_fornecedor, nome_produto, descricao, preco, unmedida, validade, imagem_produto, quantidade_produto
                FROM produto
                WHERE nome_produto LIKE :busca_nome
                ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
        $busca_nome = "%$busca%";
        $stmt->bindParam(':busca_nome', $busca_nome, PDO::PARAM_STR);
    }
} else {
    $sql = "SELECT id_produto, id_fornecedor, nome_produto, descricao, preco, unmedida, validade, imagem_produto, quantidade_produto
            FROM produto
            ORDER BY nome_produto ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
