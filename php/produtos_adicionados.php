<?php
session_start();
require_once 'conexao.php';

// Cria nova comanda
if (!isset($_SESSION['id_comanda'])) {
    date_default_timezone_set('America/Sao_Paulo'); //Fuso horario
    $status = 'Aberta';
    $data_abertura = date('Y-m-d');
    $hora_abertura = date('H:i:s');
    $id_funcionario = $_SESSION['id_funcionario'] ?? 1;

    $sql = "INSERT INTO comanda (id_funcionario, data_abertura, hora_abertura, status)
            VALUES (:id_funcionario, :data_abertura, :hora_abertura, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_funcionario' => $id_funcionario,
        ':data_abertura'  => $data_abertura,
        ':hora_abertura'  => $hora_abertura,
        ':status'         => $status
    ]);

    $_SESSION['id_comanda'] = $pdo->lastInsertId();
}

$id_comanda = $_SESSION['id_comanda'];

// Busca lista de produtos
if (empty($comanda)) {
    $sql = "SELECT * FROM item_comanda ORDER BY id_produto ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Adiciona item
if (isset($_POST['adicionar_item'])) {
    $id_produto = $_POST['id_produto'];
    $quantidade = $_POST['quantidade'];
    $observacao = $_POST['observacao'] ?? null;

    $sql = "SELECT preco FROM produto WHERE id_produto = :id_produto";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_produto' => $id_produto]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        $total = $produto['preco'] * $quantidade;

        $sql = "INSERT INTO item_comanda (id_comanda, id_produto, quantidade, observacao, total) 
                VALUES (:id_comanda, :id_produto, :quantidade, :observacao, :total)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_comanda' => $id_comanda,
            ':id_produto' => $id_produto,
            ':quantidade' => $quantidade,
            ':observacao' => $observacao,
            ':total'      => $total
        ]);
    }

    header("Location: comanda.php");
    exit;
}

// Remover item
if (isset($_POST['remover'])) {
    $id_produto = $_POST['id_produto'];

    $sql = "DELETE FROM item_comanda 
            WHERE id_comanda = :id_comanda AND id_produto = :id_produto 
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_comanda' => $id_comanda,
        ':id_produto' => $id_produto
    ]);

    header("Location: comanda.php");
    exit;
}


// Buscar itens já adicionados na comanda
$sql = "SELECT i.*, p.nome_produto, p.preco 
        FROM item_comanda i
        JOIN produto p ON i.id_produto = p.id_produto
        WHERE i.id_comanda = :id_comanda";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_comanda' => $id_comanda]);
$itens_comanda = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Comanda</title>
  <link rel="stylesheet" href="../css/styleprodutos_adicionados.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
<header>
    <img src="../img/logo_pg.png" alt="Logo da Padaria">
</header>
<div class="retangulo">
    <a href="../php/comanda.php" class="voltar"> 
        <img class="seta" src="../img/btn_voltar.png" title="Voltar">
    </a>
    <div class="retangulo-conteudo">

        <?php if (!empty($itens_comanda)): ?>
        <h2>Itens da Comanda</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
               <!-- <th>Observação</th> -->
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itens_comanda as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nome_produto']) ?></td>
                    <td><?= htmlspecialchars($item['quantidade']) ?></td>
             <!-- <td><?= htmlspecialchars($item['observacao']) ?></td> -->
                    <td>R$ <?= number_format($item['total'], 2, ',', '.') ?></td>

                    <td>
                        <button type="submit" name="adicionar_item" class="btn-adicionar">+</button>
                        <button type="submit" name="remover_item" class="btn-remover">-</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
