<?php 
require_once 'conexao.php';

/*if($_SESSION['id_funcao'] != 1) {
    echo "<script>alert('Acesso Negado!');window.location.href='../principal.php';</script>";
}*/

$funcionarios = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $busca = trim($_POST['busca']);

    if(is_numeric($busca)) {
        $sql = "SELECT f.*, func.nome_funcao 
                FROM funcionarios f
                LEFT JOIN funcao func ON f.id_funcao = func.id_funcao
                WHERE f.id_funcionario = :busca
                ORDER BY f.nome_funcionario ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT f.*, func.nome_funcao 
                FROM funcionarios f
                LEFT JOIN funcao func ON f.id_funcao = func.id_funcao
                WHERE f.nome_funcionario LIKE :busca_nome
                ORDER BY f.nome_funcionario ASC";
        $stmt = $pdo->prepare($sql);
        $busca_nome = "%$busca%";
        $stmt->bindParam(':busca_nome', $busca_nome, PDO::PARAM_STR);
    }
    
} else {
    $sql = "SELECT f.*, func.nome_funcao 
            FROM funcionarios f
            LEFT JOIN funcao func ON f.id_funcao = func.id_funcao WHERE ativo = 1
            ORDER BY f.id_funcionario ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>