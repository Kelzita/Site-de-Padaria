<?php
require_once "conexao.php";

$id_item = $_GET['id_item'] ?? null;
$id_comanda = $_GET['id'] ?? null;

if (!$id_item || !$id_comanda) {
    echo json_encode([]);
    exit;
}

// Remove item da comanda
$stmt = $pdo->prepare("DELETE FROM item_comanda WHERE id_item_comanda = :id_item");
$stmt->execute(['id_item' => $id_item]);

// Retorna lista atualizada de itens **diretamente**
$sql = "SELECT i.id_item_comanda AS id_item, i.id_comanda, 
               p.nome_produto, i.quantidade, 
               p.preco AS valor_unit, 
               (i.quantidade * p.preco) AS total
        FROM item_comanda i
        JOIN produto p ON p.id_produto = i.id_produto
        WHERE i.id_comanda = :id_comanda";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id_comanda' => $id_comanda]);
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($itens);
?>

