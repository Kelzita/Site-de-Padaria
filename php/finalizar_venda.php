<?php
require_once "conexao.php";

$id = $_GET['id'] ?? null;
$forma = $_GET['forma'] ?? "Não informada";

if (!$id) {
    echo "ID da comanda inválido!";
    exit;
}

// Marca como FECHADA e salva forma de pagamento
$stmt = $pdo->prepare("UPDATE comanda SET status = 'FECHADA', forma_pagamento = :forma WHERE id_comanda = :id");
$stmt->execute([
    'id' => $id,
    'forma' => $forma
]);

// Não apagar os itens ainda, vamos gerar a nota fiscal primeiro
// Os itens podem ser apagados depois, se desejar

echo "Venda finalizada com sucesso! Forma de pagamento: " . htmlspecialchars($forma);



