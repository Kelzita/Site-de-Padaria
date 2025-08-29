<?php
require_once "conexao.php";

$id_item = $_GET['id_item'] ?? null;
$id_comanda = $_GET['id'] ?? null;

if (!$id_item || !$id_comanda) {
    echo json_encode([]);
    exit;
}

// Remove item
$stmt = $pdo->prepare("DELETE FROM item_comanda WHERE id_item_comanda = :id_item");
$stmt->execute(['id_item' => $id_item]);

// Retorna lista atualizada
include "buscar_comanda.php";
?>
