<?php
session_start();
require_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_funcionario = $_POST['email_funcionario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM funcionarios WHERE email_funcionario = :email_funcionario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email_funcionario", $email_funcionario);
    $stmt->execute();
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($funcionario && password_verify($senha, $funcionario['senha'])) {
        // Login bem-sucedido - define variáveis de sessão
        $_SESSION['nome_funcionario'] = $funcionario['nome_funcionario'];
        $_SESSION['id_funcionario'] = $funcionario['id_funcionario'];
        $_SESSION['id_funcao'] = $funcionario['id_funcao'];

        // Redireciona para página principal
        header("Location: ../principal.php");
        exit();
    } else {
        // Login inválido
        echo "<script>alert('E-mail ou senha incorretos');window.location.href='../index.php';</script>";
    }
}
?>

