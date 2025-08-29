<?php
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Verifica se o email existe no banco de dados
    $sql = "SELECT * FROM funcionarios WHERE email_funcionario = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($funcionario) {
        // Gera uma senha temporária
        $senha_temporaria = gerarSenhaTemporaria();
        $senha_hash = password_hash($senha_temporaria, PASSWORD_DEFAULT);

        // Atualiza a senha do usuário no banco
        $sql = "UPDATE funcionarios SET senha = :senha WHERE email_funcionario = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Simula envio do e-mail (aqui você pode integrar com um serviço real de email)
        simularEnvioEmail($email, $senha_temporaria);

        echo "<script>alert('Uma senha temporária foi gerada e enviada para seu e-mail.'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Email não encontrado!');</script>";
    }
}



// Função para simular o envio de email (aqui grava em um arquivo .txt)
function simularEnvioEmail($email, $senha) {
    $mensagem = "Olá,\n\nSua nova senha temporária é: $senha\nPor favor, faça login e altere sua senha.\n\nAtenciosamente,\nEquipe";
    $arquivo = "emails_enviados/" . md5($email) . ".txt";

    // Cria pasta emails_enviados se não existir
    if (!file_exists('emails_enviados')) {
        mkdir('emails_enviados', 0777, true);
    }

    file_put_contents($arquivo, "Para: $email\n\n$mensagem");
}
?>


<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--==== Ícones ====-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <!--==== Fontes do Google ====-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap">
    <!--==== CSS - EXTERNO ====-->
    <link rel="stylesheet" href="css/stylelogin.css">

    <style>

  
    </style>
    <title>Login</title>
</head>

<body>
    <div class="login">
        <img src="../img/fundo1.jpg" alt="Fundo da página" class="background">
        <form action="#" method="post" class="formulario-style">
            <h1 class="titulo-style1">Redefinir Senha</h1>
            <div class="conteudo">
                <div class="caixa-style">
                    <i class="ri-lock-2-line login__icon"></i>
                    <div class="campo-input">
                        <input name="email" type="email" class="style-input" id="email" placeholder=" ">
                        <label for="email" class="style-label">E-mail</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="botao-style-redefinir" onclick="VerificarCampos()">Enviar código para o Email</button>
        </form>
    </div>
  </body>