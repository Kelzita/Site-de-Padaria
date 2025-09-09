<?php
session_start();
require_once "conexao.php";

// Evita qualquer saída de HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("Content-Type: application/json; charset=UTF-8");

// Pega parâmetros
$tipo  = $_GET['tipo'] ?? null;
$valor = $_GET['valor'] ?? null;

// Validação
if (!$tipo || !$valor) {
    echo json_encode(["erro" => "Dados inválidos: parâmetros ausentes."]);
    exit;
}

try {
    if ($tipo === "id") {
        $sql = "SELECT id_produto, nome_produto, preco AS valor_unit FROM produto WHERE id_produto = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$valor]);
    } elseif ($tipo === "nome") {
        $sql = "SELECT id_produto, nome_produto, preco AS valor_unit FROM produto WHERE nome_produto LIKE ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$valor%"]);
    } else {
        echo json_encode(["erro" => "Tipo de busca inválido. Use 'id' ou 'nome'."]);
        exit;
    }

    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        echo json_encode($produto, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(["erro" => "Produto não encontrado."]);
    }
} catch (Exception $e) {
    echo json_encode(["erro" => "Erro no servidor.", "detalhes" => $e->getMessage()]);
}
