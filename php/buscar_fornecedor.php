<?php 
session_start();
require_once 'conexao.php';

/*if($_SESSION['id_funcao'] != 1 && $_SESSION['id_funcao'] != 2) {
    echo "<script>alert('Acesso Negado!');window.location.href='../principal.php';</script>";
}*/

$fornecedor = [];

if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);

    if(is_numeric($busca)) {
        $sql = "SELECT id_fornecedor, razao_social, responsavel, email_fornecedor, telefone_fornecedor, cep_fornecedor
                FROM fornecedores
                WHERE id_fornecedor = :busca
                ORDER BY razao_social ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT id_fornecedor, razao_social, responsavel, email_fornecedor, telefone_fornecedor, cep_fornecedor
                FROM fornecedores
                WHERE razao_social LIKE :busca_nome
                ORDER BY razao_social ASC";
        $stmt = $pdo->prepare($sql);
        $busca_nome = "%$busca%";
        $stmt->bindParam(':busca_nome', $busca_nome, PDO::PARAM_STR);
    }
} else {
    $sql = "SELECT id_fornecedor, razao_social, responsavel, email_fornecedor, telefone_fornecedor, cep_fornecedor
            FROM fornecedores
            ORDER BY razao_social ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>