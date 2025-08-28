<?php
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['id_comanda'])) {
    $id_comanda = $_POST['id_comanda'];

    // Atualiza a comanda para finalizada
    $sql = "UPDATE comanda SET status = 'finalizada' = NOW() WHERE id_comanda = :id_comanda";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_comanda', $id_comanda, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: caixa.php");
    exit;
}
?>