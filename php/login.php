<?php
session_start();
require_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM funcionarios WHERE email_funcionario = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($funcionario && password_verify($senha, $funcionario['senha'])) {
        // Login bem-sucedido - define variáveis de sessão
        $_SESSION['nome_funcionario'] = $funcionario['nome_funcionario'];
        $_SESSION['id_funcionario'] = $funcionario['id_funcionario'];
        $_SESSION['id_funcao'] = $funcionario['id_funcao'];

        // Redireciona para página principal
        header("Location: principal.php");
        exit();
    } else {
        // Login inválido
        echo "<script>alert('E-mail ou senha incorretos');window.location.href='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Funcionário</title>
    <link rel="stylesheet" href="stylelogin.css">
</head>
<body>
    <h2>Login Funcionário</h2>
    <form action="login.php" method="POST">
        <label for="email">E-mail</label>
        <input type="text" id="email" name="email" required>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Entrar</button>
    </form>

    <p><a href="recuperar_senha.php">Esqueci a minha senha</a></p>
</body>
</html>

