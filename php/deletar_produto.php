<?php
session_start();
require 'conexao.php'; // conexão PDO

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_produto = $_POST['id_produto'] ?? 0;
    $id_produto = intval($id_produto);

    if ($id_produto <= 0) {
        echo "<script>alert('ID do produto inválido!');history.back();</script>";
        exit;
    }

    try {
        $sql = "DELETE FROM produto WHERE id_produto = :id_produto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_produto', $id_produto, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('Produto deletado com sucesso!');window.location.href='../html_listas/lista_de_produto.php';</script>";
        exit;

    } catch (PDOException $e) {
        echo "<script>alert('Erro ao deletar produto: " . $e->getMessage() . "');history.back();</script>";
        exit;
    }
} else {
    // Se alguém tentar acessar via GET
    echo "<script>alert('Acesso inválido!');window.location.href='../html_listas/lista_de_produto.php';</script>";
    exit;
}
?>
