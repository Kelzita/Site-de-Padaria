<?php
session_start();
require 'conexao.php'; // conexão PDO

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_fornecedor = $_POST['id_fornecedor'] ?? 0;
    $id_fornecedor = intval($id_fornecedor);

    if ($id_fornecedor <= 0) {
        echo "<script>alert('ID do fornecedor inválido!');history.back();</script>";
        exit;
    }

    try {
        $sql = "DELETE FROM fornecedores WHERE id_fornecedor = :id_fornecedor";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('Fornecedor deletado com sucesso!');window.location.href='../html_listas/lista_de_fornecedores.php';</script>";
        exit;

    } catch (PDOException $e) {
        echo "<script>alert('Erro ao deletar fornecedor: " . $e->getMessage() . "');history.back();</script>";
        exit;
    }
} else {
    // Se alguém tentar acessar via GET
    echo "<script>alert('Acesso inválido!');window.location.href='../html_listas/lista_de_fornecedores.php';</script>";
    exit;
}
?>
