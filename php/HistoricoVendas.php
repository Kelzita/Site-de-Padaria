<?php
require_once "conexao.php";
require_once 'menu.php';

// Configuração da paginação
$itensPorPagina = 20;
$paginaAtual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$offset = ($paginaAtual - 1) * $itensPorPagina;

// Pegar as datas enviadas pelo formulário
$dataInicial = $_GET['dataInicial'] ?? null;
$dataFinal   = $_GET['dataFinal'] ?? null;

// SQL base (para contar total de registros e total geral)
$sqlCount = "
    SELECT COUNT(*) as total, SUM(ic.total) as totalGeral
    FROM comanda c
    INNER JOIN item_comanda ic ON c.id_comanda = ic.id_comanda
    INNER JOIN produto p ON ic.id_produto = p.id_produto
    WHERE LOWER(c.status) = 'fechada'
      AND c.data_fechamento IS NOT NULL
";
$params = [];
if ($dataInicial && $dataFinal) {
    $sqlCount .= " AND c.data_fechamento BETWEEN :dataInicial AND :dataFinal";
    $params[':dataInicial'] = $dataInicial;
    $params[':dataFinal']   = $dataFinal;
}
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->execute($params);
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$totalRegistros = $rowCount['total'];
$totalGeralTodasVendas = $rowCount['totalGeral'];
$totalPaginas = ceil($totalRegistros / $itensPorPagina);

// SQL principal com LIMIT e OFFSET
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

if ($dataInicial && $dataFinal) {
    $sql .= " AND c.data_fechamento BETWEEN :dataInicial AND :dataFinal";
}

$sql .= " ORDER BY c.data_fechamento ASC, c.hora_fechamento ASC
          LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
if ($dataInicial && $dataFinal) {
    $stmt->bindValue(':dataInicial', $dataInicial);
    $stmt->bindValue(':dataFinal', $dataFinal);
}
$stmt->bindValue(':limit', $itensPorPagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total da página atual
$totalGeralPagina = array_sum(array_column($vendas,'total'));

// Controle de exibição de números
$mostrarNumeros = isset($_GET['mostrarNumeros']) && $_GET['mostrarNumeros'] == 1;

// Função para gerar intervalo de páginas tipo “carrossel”
function gerarIntervaloPaginas($paginaAtual, $totalPaginas, $maxLinks = 5) {
    $links = [];
    if ($totalPaginas <= $maxLinks) {
        for ($i=1;$i<=$totalPaginas;$i++) $links[] = $i;
    } else {
        $inicio = max(1, $paginaAtual - 2);
        $fim = min($totalPaginas, $paginaAtual + 2);
        if ($inicio > 1) $links[] = 1;
        if ($inicio > 2) $links[] = '...';
        for ($i=$inicio;$i<=$fim;$i++) $links[] = $i;
        if ($fim < $totalPaginas-1) $links[] = '...';
        if ($fim < $totalPaginas) $links[] = $totalPaginas;
    }
    return $links;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Histórico de Vendas</title>
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/stylesHV.css">
<link rel="stylesheet" href="../css/stylehome.css">
<link rel="icon" href="img/logo_title.png">
</head>
<body>
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
    Total Geral da Página: <span class="valorTG">R$ <?= number_format($totalGeralPagina, 2, ',', '.') ?></span><br>
</div>
<div class="total-geral">
Total Geral de Todas as Vendas: <span class="valorTG">R$ <?= number_format($totalGeralTodasVendas, 2, ',', '.') ?></span>
        </div>
<!-- PAGINAÇÃO -->
<div class="paginacao">
    <!-- Anterior -->
    <?php if ($paginaAtual > 1): ?>
        <a href="?pagina=<?= $paginaAtual-1 ?>&dataInicial=<?= $dataInicial ?>&dataFinal=<?= $dataFinal ?>&mostrarNumeros=1">«</a>
    <?php else: ?>
        <span>«</span>
    <?php endif; ?>

    <!-- Números de página -->
    <?php if ($mostrarNumeros): 
        $links = gerarIntervaloPaginas($paginaAtual, $totalPaginas);
        foreach ($links as $l): 
            if ($l === '...'): ?>
                <span>...</span>
            <?php elseif ($l == $paginaAtual): ?>
                <span class="atual numero"><?= $l ?></span>
            <?php else: ?>
                <a class="numero" href="?pagina=<?= $l ?>&dataInicial=<?= $dataInicial ?>&dataFinal=<?= $dataFinal ?>&mostrarNumeros=1"><?= $l ?></a>
            <?php endif; 
        endforeach; 
    endif; ?>

    <!-- Próximo -->
    <?php if ($paginaAtual < $totalPaginas): ?>
        <a href="?pagina=<?= $paginaAtual+1 ?>&dataInicial=<?= $dataInicial ?>&dataFinal=<?= $dataFinal ?>&mostrarNumeros=1">»</a>
    <?php else: ?>
        <span>»</span>
    <?php endif; ?>
</div>



<?php else: ?>
<div class="semVenda"><p>Nenhuma venda encontrada neste período.</p></div>
<?php endif; ?>

<br>
<a href="historicodevendas.php" class="voltar"> 
      <img class="seta1" src="../img/btn_voltar.png" title="seta">
</a>

</body>
</html>
