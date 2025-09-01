<?php
require_once "conexao.php";

$id = $_GET['id'] ?? null;
$forma = $_GET['forma'] ?? "Não informada";

if (!$id) {
    echo "ID da comanda inválido!";
    exit;
}

// data e hora atuais
date_default_timezone_set('America/Sao_Paulo'); //Fuso horario
$data_fechamento = date("Y-m-d");
$hora_fechamento = date("H:i:s");

// Marca como FECHADA e salva forma de pagamento + data/hora de fechamento
$stmt = $pdo->prepare("
    UPDATE comanda 
    SET status = 'FECHADA', 
        forma_pagamento = :forma,
        data_fechamento = :data,
        hora_fechamento = :hora
    WHERE id_comanda = :id
");

$stmt->execute([
    'id'   => $id,
    'forma'=> $forma,
    'data' => $data_fechamento,
    'hora' => $hora_fechamento
]);

echo "Venda finalizada com sucesso! Forma de pagamento: " . htmlspecialchars($forma);

