<?php
require_once 'conexao.php';

if (isset($_GET['id'])) {
    $id_funcionario = $_GET['id'];
    
    $stmt = $pdo->prepare("SELECT imagem_funcionario FROM funcionarios WHERE id_funcionario = ?");
    $stmt->execute([$id_funcionario]);
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($funcionario && !empty($funcionario['imagem_funcionario'])) {
        header("Content-Type: image/jpeg");
        echo $funcionario['imagem_funcionario'];
    } else {
        // Imagem padrão caso não tenha foto
        header("Content-Type: image/jpeg");
        readfile('../img/avatars/default_avatar.png');
    }
    exit;
}
?>