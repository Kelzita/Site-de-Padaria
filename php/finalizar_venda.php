<?php
require_once "conexao.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID da comanda inválido!";
    exit;
}

// Marca como FECHADA
$stmt = $pdo->prepare("UPDATE comanda SET status = 'FECHADA' WHERE id_comanda = :id");
$stmt->execute(['id' => $id]);

// Zera itens da comanda (opcional)
$stmtDelete = $pdo->prepare("DELETE FROM item_comanda WHERE id_comanda = :id");
$stmtDelete->execute(['id' => $id]);

echo "Venda finalizada com sucesso!";
?>


