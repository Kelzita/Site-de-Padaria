<?php
require_once "conexao.php";

$id = $_GET['id'] ?? null;
$forma = $_GET['forma'] ?? "Não informada";

if (!$id) {
    echo "ID da comanda inválido!";
    exit;
}

try {
    // Inicia transação
    $pdo->beginTransaction();

    // 1. Busca os itens da comanda com os produtos
    $sqlItens = "
        SELECT ic.id_produto, ic.quantidade, p.quantidade_produto, p.nome_produto
        FROM item_comanda ic
        JOIN produto p ON ic.id_produto = p.id_produto
        WHERE ic.id_comanda = :id
    ";
    $stmtItens = $pdo->prepare($sqlItens);
    $stmtItens->execute(['id' => $id]);
    $itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

    if (!$itens) {
        throw new Exception("Nenhum item encontrado para esta comanda.");
    }

    $alertas = [];

    // 2. Atualiza estoque de cada produto
    foreach ($itens as $item) {
        $novoEstoque = $item['quantidade_produto'] - $item['quantidade'];

        if ($novoEstoque < 0) {
            throw new Exception("Estoque insuficiente para o produto ID: {$item['id_produto']}");
        }

        $updateEstoque = "UPDATE produto SET quantidade_produto = :novo WHERE id_produto = :produto";
        $stmtEstoque = $pdo->prepare($updateEstoque);
        $stmtEstoque->execute([
            'novo'    => $novoEstoque,
            'produto' => $item['id_produto']
        ]);

        // ⚠ Se estoque <= 20, gera alerta
        if ($novoEstoque <= 20) {
            $alertas[] = "⚠ O produto <b>{$item['nome_produto']}</b> está com estoque baixo ({$novoEstoque} unidades).";
        }
    }

    // 3. Fecha a comanda
    date_default_timezone_set('America/Sao_Paulo');
    $data_fechamento = date("Y-m-d");
    $hora_fechamento = date("H:i:s");

    $sqlComanda = "
        UPDATE comanda 
        SET status = 'FECHADA', 
            forma_pagamento = :forma,
            data_fechamento = :data,
            hora_fechamento = :hora
        WHERE id_comanda = :id
    ";
    $stmtComanda = $pdo->prepare($sqlComanda);
    $stmtComanda->execute([
        'id'    => $id,
        'forma' => $forma,
        'data'  => $data_fechamento,
        'hora'  => $hora_fechamento
    ]);

    // 4. Confirma tudo
    $pdo->commit();

    // 5. Exibe mensagem final + alertas (somente texto)
    $msg = "✅ Venda finalizada com sucesso! Forma de pagamento: " . htmlspecialchars($forma);

    if (!empty($alertas)) {
        $msg .= "\n" . implode("\n", array_map('strip_tags', $alertas));
    }

echo $msg;


} catch (Exception $e) {
    $pdo->rollBack();
    echo "❌ Erro ao finalizar venda: " . $e->getMessage();
}



