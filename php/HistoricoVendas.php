<?php
require_once "conexao.php";

// Pegar as datas enviadas pelo formulário
$dataInicial = $_GET['dataInicial'] ?? null;
$dataFinal   = $_GET['dataFinal'] ?? null;

// Montar a query base
$sql = "
    SELECT 
        c.id_comanda,
        c.data_fechamento,
        c.hora_fechamento,
        c.forma_pagamento,
        p.nome_produto,
        ic.quantidade,
        ic.total
    FROM comanda c
    INNER JOIN item_comanda ic ON c.id_comanda = ic.id_comanda
    INNER JOIN produto p ON ic.id_produto = p.id_produto
    WHERE LOWER(c.status) = 'fechada'
      AND c.data_fechamento IS NOT NULL
";

// Se tiver datas selecionadas, aplicar o filtro
$params = [];
if ($dataInicial && $dataFinal) {
    $sql .= " AND c.data_fechamento BETWEEN :dataInicial AND :dataFinal";
    $params[':dataInicial'] = $dataInicial;
    $params[':dataFinal']   = $dataFinal;
}

$sql .= " ORDER BY c.data_fechamento DESC, c.hora_fechamento DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular total geral
$totalGeral = 0;
foreach ($vendas as $venda) {
    $totalGeral += $venda['total'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Histórico de Vendas</title>
  <link rel="stylesheet" href="../css/styles.css" />
  <link rel="stylesheet" href="../css/stylesHV.css">
</head>
<body>
  <header>
    <img src="../img/logo.png" title="Logo da Padaria">
  </header>

  <div class="titulos">
      <h1>Histórico de Vendas</h1>
      <?php if ($dataInicial && $dataFinal): ?>
          <p><strong>Período:</strong> <?= date('d/m/Y', strtotime($dataInicial)) ?> até <?= date('d/m/Y', strtotime($dataFinal)) ?></p>
      <?php endif; ?>
  </div>

  <?php if ($vendas): ?>
    <table>
      <thead>
        <tr>
          <th>ID Comanda</th>
          <th>Data</th>
          <th>Hora</th>
          <th>Forma de Pagamento</th>
          <th>Produto</th>
          <th>Quantidade</th>
          <th>Total (R$)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($vendas as $venda): ?>
          <tr>
            <td><?= $venda['id_comanda'] ?></td>
            <td><?= date('d/m/Y', strtotime($venda['data_fechamento'])) ?></td>
            <td><?= date('H:i', strtotime($venda['hora_fechamento'])) ?></td>
            <td><?= $venda['forma_pagamento'] ?></td>
            <td><?= $venda['nome_produto'] ?></td>
            <td><?= $venda['quantidade'] ?></td>
            <td><?= number_format($venda['total'], 2, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="total-geral">
        Total Geral:<div class="valorTG"> R$ <?= number_format($totalGeral, 2, ',', '.') ?></div>
    </div>

  <?php else: ?>
      <div class="semVenda"><p>Nenhuma venda encontrada neste período.</p></div>
  <?php endif; ?>

  <br>
  <a href="../historicodevendas.html" class="voltar"> 
        <img class="seta1" src="../img/btn_voltar.png" title="seta">
    </a>

</body>
</html>

