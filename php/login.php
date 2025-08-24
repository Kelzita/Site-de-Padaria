<?php 
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE nome_usuario = :nome_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_usuario', $nome_usuario);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario && $senha == $usuario['senha']) {
        //Se o login for bem sucedido, irá definir as variáveis de sessão
        $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
        $_SESSION['funcao'] = $usuario['id_funcao'];
        $_SESSION['id_usuario'] = $usuario['id_usuario'];

        //Verifica se a senha é temporária
        if($usuario['senha_temporaria']) { 
            //Redireciona para a troca de senha
            header("Location: alterar_senha.php");
            exit();
        } else {
            //Redireciona para a página principal
            echo "<script>alert('Usuário logado com sucesso!'); window.location.href='../home.php';</script>";
            exit();
         }
    
    } else {
        //Login inválido
        echo "<script>alert('Usuário ou senha incorretos'); window.location.href='../index.php';</script>";
    } 
} 
?>