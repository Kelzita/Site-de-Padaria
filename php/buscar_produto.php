<?php
require_once "conexao.php";

$id_comanda = $_GET['id'] ?? null;
$codigo = $_GET['codigo'] ?? null;

if (!$id_comanda || !$codigo) {
    echo json_encode([]);
    exit;
}

// Busca produto pelo código
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE codigo = :codigo");
$stmt->execute(['codigo' => $codigo]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($produto) {
    $stmtInsert = $pdo->prepare("INSERT INTO itens_comanda (id_comanda, id_produto, qtd) VALUES (:id_comanda, :id_produto, 1)");
    $stmtInsert->execute([
        'id_comanda' => $id_comanda,
        'id_produto' => $produto['id']
    ]);
}

// Retorna lista atualizada
include "buscar_comanda.php";
?>
