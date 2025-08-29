<?php
session_start();
require_once("conexao.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    //VERIFICA SE O EMAIL EXISTE NO BANCO DE DADOS
    $sql = "SELECT * FROM funcionarios WHERE email_funcionario = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($funcionario) {
        //GERA UMA SENHA TEMPORARIA
        $senha_temporaria = gerarSenhaTemporaria();
        $senha_hash = password_hash($senha_temporaria, PASSWORD_DEFAULT);

        //ATUALIZA A SENHA DO USUARIO NO BANCO
        $sql = "UPDATE funcionario SET senha = :senha, senha_temporaria = TRUE WHERE email_funcionario = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
 
        //SIMULA O ENVIO DO EMAIL (GRAVA TXT)
        simularEnvioEmail($email, $senha_temporaria);
        echo "<script>alert('Uma senha nova foi gerada e enviada . ');window.location.href='index.php';</script>";

    } else {
        echo "<script>alert('Email não encontrado!');</script>";
    }
}
?>
