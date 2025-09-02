<?php
require_once "conexao.php";

$tipo = $_GET['tipo'] ?? null;
$valor = $_GET['valor'] ?? null;

if (!$tipo || !$valor) {
    echo json_encode(["erro" => "Dados inválidos"]);
    exit;
}

if ($tipo === "id") {
    $sql = "SELECT * FROM produto WHERE id_produto = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$valor]);
} else {
    $sql = "SELECT * FROM produto WHERE nome_produto LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$valor%"]);
}

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($produto) {
    echo json_encode($produto);
} else {
    echo json_encode(["erro" => "Produto não encontrado"]);
}

?>