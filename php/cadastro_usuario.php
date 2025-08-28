<?php 
require_once 'conexao.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_funcionario = $_POST['id_funcionario'];
        $nome_usuario = $_POST['nome_usuario'];
        $senha = $_POST['senha'];

        $sql = "INSERT INTO usuario (nome_usuario, senha ) VALUES (:nome_usuario, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_usuario', $nome_usuario);
        $stmt->bindParam(':senha', $senha);

        if($stmt->execute()) {
            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='../html_listas/lista_funcionario.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar o usuário !');</script>";

        }
}
