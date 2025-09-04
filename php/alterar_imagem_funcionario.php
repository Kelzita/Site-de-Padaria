<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION['id_funcionario'])) {
    header("Location: ../login.php");
    exit;
}

$id_funcionario = $_SESSION['id_funcionario'];

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_FILES['imagem_funcionario']) && $_FILES['imagem_funcionario']['error'] === UPLOAD_ERR_OK) {
    $imagem_blob = file_get_contents($_FILES['imagem_funcionario']['tmp_name']);

    try {
        $stmt = $pdo->prepare("UPDATE funcionarios SET imagem_funcionario = :imagem WHERE id_funcionario = :id");
        $stmt->bindParam(':imagem', $imagem_blob, PDO::PARAM_LOB);
        $stmt->bindParam(':id', $id_funcionario, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('Imagem atualizada com sucesso!'); window.location.href='../html_listas/lista_de_funcionarios.php';</script>";
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar imagem: " . $e->getMessage();
        exit;
    }
} else {
    echo "<script>alert('Nenhuma imagem selecionada ou houve um erro.'); window.location.href='../html_listas/perfil.php';</script>";
}
