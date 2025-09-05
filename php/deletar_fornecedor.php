<?php
// deletar_fornecedor.php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_fornecedor = intval($_POST['id_fornecedor'] ?? 0);

    if ($id_fornecedor > 0) {
        $sql = "DELETE FROM fornecedores WHERE id_fornecedor = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id_fornecedor, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Voltar para a lista
    header("Location: ../html_listas/lista_de_fornecedores.php");
    exit;
}
?>