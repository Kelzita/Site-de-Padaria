<?php 
require_once 'conexao.php';

//busca as funções cadastradas no banco
$sql = "SELECT * FROM funcao";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$funcoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ID da função selecionada (se estiver editando um funcionário)
$idSelecionado = isset($funcionario['id_funcao']) ? $funcionario['id_funcao'] : null;
?>

