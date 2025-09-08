<?php
session_start();
require_once "conexao.php";
header("Content-Type: application/json; charset=UTF-8");

// Pega dados via GET
$id_comanda  = $_GET['id_comanda'] ?? null;
$id_produto  = $_GET['id_produto'] ?? null;
$quantidade  = $_GET['quantidade'] ?? 1;
$observacao  = $_GET['observacao'] ?? null;

if (!$id_comanda) {
    echo json_encode(["erro" => "ID da comanda não informado!"]);
    exit;
}

if (!$id_produto) {
    echo json_encode(["erro" => "Produto não informado"]);
    exit;
}

// Busca preço do produto
$sql = "SELECT preco FROM produto WHERE id_produto = :id_produto";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_produto' => $id_produto]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo json_encode(["erro" => "Produto não encontrado"]);
    exit;
}

$preco = $produto['preco'];
$total = $preco * $quantidade;

// Insere item na comanda
$sql = "INSERT INTO item_comanda (id_comanda, id_produto, quantidade, observacao, total)
        VALUES (:id_comanda, :id_produto, :quantidade, :observacao, :total)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'id_comanda' => $id_comanda,
    'id_produto' => $id_produto,
    'quantidade' => $quantidade,
    'observacao' => $observacao,
    'total' => $total
]);

// Retorna lista atualizada de itens
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

echo json_encode($itens, JSON_UNESCAPED_UNICODE);

