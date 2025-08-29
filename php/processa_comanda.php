<?php
session_start();
require_once 'conexao.php';

// ===== CRIAR COMANDA =====
if (isset($_POST['criar_comanda'])) {
    $status = 'Aberta';
    $data_abertura = date('Y-m-d');
    $hora_abertura = date('H:i:s');

    // Substitua pelo ID do funcionário logado
    $id_funcionario = 1;

    $sql = "INSERT INTO comanda (id_funcionario, data_abertura, hora_abertura, status) 
            VALUES (:id_funcionario, :data_abertura, :hora_abertura, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_funcionario' => $id_funcionario,
        ':data_abertura' => $data_abertura,
        ':hora_abertura' => $hora_abertura,
        ':status' => $status
    ]);

    // Pega o ID gerado automaticamente
    $_SESSION['id_comanda'] = $pdo->lastInsertId();

    header("Location: comanda.php");
    exit;
}

// ===== ADICIONAR ITEM =====
if (isset($_POST['adicionar_item'])) {
    $id_comanda = $_SESSION['id_comanda'] ?? null;
    $id_produto = $_POST['id_produto'];
    $quantidade = $_POST['quantidade'];

    if ($id_comanda) {
        $sql = "SELECT preco FROM produto WHERE id_produto = :id_produto";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_produto' => $id_produto]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        $total = $produto['preco'] * $quantidade;

        $sql = "INSERT INTO item_comanda (id_comanda, id_produto, quantidade, total) 
                VALUES (:id_comanda, :id_produto, :quantidade, :total)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_comanda' => $id_comanda,
            ':id_produto' => $id_produto,
            ':quantidade' => $quantidade,
            ':total' => $total
        ]);
    }

    header("Location: comanda.php");
    exit;
}

// ===== FINALIZAR VENDA =====
if (isset($_POST['finalizar_venda'])) {
    $id_comanda = $_SESSION['id_comanda'] ?? null;
    $forma_pagamento = $_POST['forma_pagamento'] ?? 'Não especificado';

    if ($id_comanda) {
        $sql = "UPDATE comanda 
                SET status = 'Finalizada', forma_pagamento = :pagamento
                WHERE id_comanda = :id_comanda";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':pagamento' => $forma_pagamento,
            ':id_comanda' => $id_comanda
        ]);

        // Limpa a sessão para criar nova comanda
        unset($_SESSION['id_comanda']);
    }

    header("Location: comanda.php");
    exit;
}

// ===== BUSCAR PRODUTO =====
if (isset($_POST['buscar_produto']) && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);
    if (is_numeric($busca)) {
        $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':busca' => $busca]);
    } else {
        $sql = "SELECT * FROM produto WHERE nome_produto LIKE :busca_nome ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':busca_nome' => "%$busca%"]);
    }

    $_SESSION['produtos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header("Location: comanda.php");
    exit;
}
