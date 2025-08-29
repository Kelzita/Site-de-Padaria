<?php
require_once "conexao.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT i.id_item_comanda AS id_item, i.id_comanda, p.nome_produto, i.quantidade, p.preco AS valor_unit, (i.quantidade * p.preco) AS total
        FROM item_comanda i
        JOIN produto p ON p.id_produto = i.id_produto
        WHERE i.id_comanda = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($dados);
?>
