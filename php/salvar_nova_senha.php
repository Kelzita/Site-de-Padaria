<?php
session_start();
require_once "conexao.php";

$id = $_SESSION['id_funcionario'] ?? null;
$nova_senha = $_POST['nova_senha'] ?? '';
$confirma_senha = $_POST['confirma_senha'] ?? '';

if ($id && $nova_senha && $confirma_senha) {
    if ($nova_senha === $confirma_senha) {
        $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE funcionarios SET senha = ?, senha_temporaria = 0 WHERE id_funcionario = ?");
        $stmt->execute([$hash, $id]);

        session_destroy();
        echo "<script>alert('Senha redefinida com sucesso!'); window.location='../index.php';</script>";
    } else {
        echo "<script>alert('As senhas não coincidem!'); window.location='../nova_senha.php';</script>";
    }
} else {
    echo "<script>alert('Preencha todos os campos!'); window.location='../nova_senha.php';</script>";
}
?>
