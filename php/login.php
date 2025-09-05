<?php
session_start();
require_once('conexao.php'); // Conexão PDO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email_funcionario = $_POST['email_funcionario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if ($email_funcionario && $senha) {

        // Busca funcionário pelo e-mail
        $sql = "SELECT * FROM funcionarios WHERE email_funcionario = :email_funcionario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":email_funcionario", $email_funcionario);
        $stmt->execute();
        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($funcionario && password_verify($senha, $funcionario['senha'])) {

            // Busca a função do funcionário na tabela funcao
            $sqlFuncao = "SELECT nome_funcao FROM funcao WHERE id_funcao = :id_funcao";
            $stmtFuncao = $pdo->prepare($sqlFuncao);
            $stmtFuncao->bindParam(":id_funcao", $funcionario['id_funcao']);
            $stmtFuncao->execute();
            $funcao = $stmtFuncao->fetch(PDO::FETCH_ASSOC);

            if (!$funcao) {
                echo "<script>alert('Função do funcionário não encontrada!'); window.location='../index.php';</script>";
                exit;
            }

           // Armazena informações na sessão
            $_SESSION['id_funcionario'] = $funcionario['id_funcionario'];
            $_SESSION['nome_funcionario'] = $funcionario['nome_funcionario'];
            $_SESSION['id_funcao'] = $funcionario['id_funcao'];
            $_SESSION['nome_funcao'] = $funcao['nome_funcao'];

            // ====== ADICIONA FOTO NA SESSÃO ======
            if (!empty($funcionario['imagem_funcionario'])) {
             $_SESSION['imagem_funcionario'] = 'data:image/jpeg;base64,' . base64_encode($funcionario['imagem_funcionario']);
            } else {
             $_SESSION['imagem_funcionario'] = '../img/default_avatar.png';
            }

            
            // Redireciona dependendo da senha temporária
            if ($funcionario['senha_temporaria'] == 1) {
                header("Location: ../nova_senha.php");
                exit;
            }

            // Login normal
            header("Location: ../inicio/home.php");
            exit;

        } else {
            echo "<script>alert('E-mail ou senha incorretos'); window.location='../index.php';</script>";
        }

    } else {
        echo "<script>alert('Preencha todos os campos!'); window.location='../index.php';</script>";
    }
} else {
    // Requisição não POST
    header("Location: ../index.php");
    exit;
}
?>
