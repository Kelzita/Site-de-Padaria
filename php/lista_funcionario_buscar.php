<?php 
session_start();
require_once 'conexao.php';

$funcionarios = []; // inicializa a variável para não dar erro

$sql = "SELECT f.id_funcionario, f.nome_funcionario, f.email_funcionario, f.telefone_funcionario, f.senha, fn.nome_funcao
        FROM funcionarios f 
        JOIN funcao fn ON f.id_funcao = fn.id_funcao
        ORDER BY nome_funcionario ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($funcionarios)) {
    echo "Tabela vazia ou conexão com o banco falhou!";
} else {
    echo "<pre>";
    print_r($funcionarios);
    echo "</pre>";
}



//$funcionarios = []; 

/*if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['buscar_funcionario'])) {
    $buscar_funcionario = trim($_POST['buscar_funcionario']);
if(is_numeric($buscar_funcionario)) {
        $sql = "SELECT f.id_funcionario, f.nome_funcionario, f.email_funcionario, f.telefone_funcionario, f.senha, fn.nome_funcao
                FROM funcionarios f 
                JOIN funcao fn ON f.id_funcao = fn.id_funcao
                WHERE f.id_funcionario = :buscar_funcionario
                ORDER BY nome_funcionario ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':buscar_funcionario', $buscar_funcionario, PDO::PARAM_INT);

    } else {
        $sql = "SELECT f.id_funcionario, f.nome_funcionario, f.email_funcionario, f.telefone_funcionario, f.senha, fn.nome_funcao
                FROM funcionarios f 
                JOIN funcao fn ON f.id_funcao = fn.id_funcao
                WHERE f.nome_funcionario LIKE :busca_nome_funcionario
                ORDER BY nome_funcionario ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome_funcionario', "%$buscar_funcionario%", PDO::PARAM_STR);
    }

} else {
    $sql = "SELECT f.id_funcionario, f.nome_funcionario, f.email_funcionario, f.telefone_funcionario, f.senha, fn.nome_funcao
            FROM funcionarios f 
            JOIN funcao fn ON f.id_funcao = fn.id_funcao
            ORDER BY nome_funcionario ASC";

    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);*/
?>
