<?php
session_start();
require_once("conexao.php");
require_once("menu.php");

// ------------------- FUNÇÕES ------------------- //
function fetchData($pdo, $sql, $params = []) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ------------------- FILTROS ------------------- //
$mesSelecionado = $_GET['mes'] ?? null; // Para pagamentos e produtos
$anoSelecionado = $_GET['ano'] ?? date('Y'); // Para receita mensal

// ------------------- RECEITA MENSAL ------------------- //
$sqlReceitaMensal = "
    SELECT 
        MONTH(c.data_fechamento) AS mes,
        COALESCE(SUM(ic.total), 0) AS receita
    FROM comanda c
    INNER JOIN item_comanda ic ON c.id_comanda = ic.id_comanda
    INNER JOIN produto p ON ic.id_produto = p.id_produto
    WHERE LOWER(c.status) = 'fechada'
      AND c.data_fechamento IS NOT NULL
      AND YEAR(c.data_fechamento) = :ano
    GROUP BY MONTH(c.data_fechamento)
    ORDER BY mes
";
$receitaMensal = fetchData($pdo, $sqlReceitaMensal, [':ano'=>$anoSelecionado]);

$nomesMeses = [
  1=>'Janeiro', 2=>'Fevereiro', 3=>'Março', 4=>'Abril',
  5=>'Maio', 6=>'Junho', 7=>'Julho', 8=>'Agosto',
  9=>'Setembro', 10=>'Outubro', 11=>'Novembro', 12=>'Dezembro'
];

$labelsM = [];
$valuesM = [];
foreach ($receitaMensal as $r) {
    $labelsM[] = $nomesMeses[(int)$r['mes']];
    $valuesM[] = (float)$r['receita'];
}

// ------------------- LISTA DE MESES PARA FILTRO ------------------- //
$mesesDisponiveis = fetchData($pdo, "
    SELECT DISTINCT DATE_FORMAT(data_fechamento, '%Y-%m') AS ano_mes
    FROM comanda
    WHERE LOWER(status)='fechada'
    ORDER BY ano_mes DESC
");

$mesesFormatados = [];
$anosDisponiveis = [];
foreach($mesesDisponiveis as $m){
    [$ano,$mes] = explode('-', $m['ano_mes']);
    $mesesFormatados[] = [
        'valor' => $m['ano_mes'],
        'texto' => $nomesMeses[(int)$mes]."/$ano"
    ];
    if(!in_array($ano, $anosDisponiveis)) $anosDisponiveis[] = $ano;
}

// ------------------- FORMAS DE PAGAMENTO ------------------- //
$formasFixas = ['dinheiro','pix','cartao de debito','cartao de credito','vale alimentacao'];
$coresFixas = ['#3D2412','#B88C6D','#F5E6C7','#A67B5B','#CBAE8B'];

$sqlPagamentos = "
    SELECT LOWER(c.forma_pagamento) AS forma, COUNT(*) AS total
    FROM comanda c
    WHERE LOWER(c.status)='fechada'
";
$paramsPag = [];
if($mesSelecionado){
    $sqlPagamentos .= " AND DATE_FORMAT(c.data_fechamento, '%Y-%m') = :mes";
    $paramsPag[':mes'] = $mesSelecionado;
}
$sqlPagamentos .= " GROUP BY LOWER(c.forma_pagamento)";
$pagamentosRaw = fetchData($pdo, $sqlPagamentos, $paramsPag);

$pagamentosAssoc = [];
foreach($pagamentosRaw as $p){
    $pagamentosAssoc[$p['forma']] = (int)$p['total'];
}

$labelsP = $formasFixas;
$valuesP = [];
foreach($formasFixas as $f){
    $valuesP[] = $pagamentosAssoc[$f] ?? 0;
}

// ------------------- TOP 5 PRODUTOS ------------------- //
$sqlTopProdutos = "
    SELECT p.nome_produto, SUM(ic.quantidade) AS total_vendido
    FROM item_comanda ic
    JOIN comanda c ON c.id_comanda = ic.id_comanda
    JOIN produto p ON p.id_produto = ic.id_produto
    WHERE LOWER(c.status)='fechada'
";
$paramsTop = [];
if($mesSelecionado){
    $sqlTopProdutos .= " AND DATE_FORMAT(c.data_fechamento, '%Y-%m') = :mes";
    $paramsTop[':mes'] = $mesSelecionado;
}
$sqlTopProdutos .= " GROUP BY p.id_produto ORDER BY total_vendido DESC LIMIT 5";
$topProdutos = fetchData($pdo, $sqlTopProdutos, $paramsTop);

$labelsT = [];
$valuesT = [];
foreach($topProdutos as $t){
    $labelsT[] = $t['nome_produto'];
    $valuesT[] = (float)$t['total_vendido'];
}
$coresTop=['#3D2412','#B88C6D','#F5E6C7','#A67B5B','#CBAE8B'];

// Preparar título para pagamentos e produtos
$tituloPagProd = "Mês: ";
if($mesSelecionado){
    [$anoFiltro, $mesFiltro] = explode('-', $mesSelecionado);
    $tituloPagProd .= $nomesMeses[(int)$mesFiltro]."/$anoFiltro";
} else {
    $tituloPagProd .= "Todos";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Dashboard Padaria</title>
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {
    font-family: 'Times New Roman', serif;
    background-image: url('../img/fundo_padaria.png');
    background-size: cover;
    margin: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.dashboard { max-width: 1100px; width: 100%; margin-top: 80px; }
.chart-container, .card {
    background-color: rgba(255,255,255,0.9);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
    text-align: center;
    box-shadow: 0 6px 15px rgba(0,0,0,0.25);
}
.cards-horizontal { display: flex; gap: 30px; justify-content: center; flex-wrap: wrap; margin-bottom: 30px; }
.large-card { flex: 1 1 450px; max-width: 500px; min-width: 300px; }
canvas { width: 100% !important; height: 350px !important; }
#graficoReceita { height: 400px !important; }

/* filtros */
.filtros {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}
.filtro-box {
    background: rgba(255,255,255,0.95);
    padding: 18px 22px;
    border-radius: 12px;
    text-align: center;
    min-width: 240px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.filtro-box h3 {
    margin: 0 0 10px;
    font-size: 16px;
    color: #3D2412;
}
.filtro-box input {
    padding: 6px 10px;
    border: 1px solid #B88C6D;
    border-radius: 6px;
    font-size: 14px;
    width: 150px;
}
.filtro-box button {
    margin-top: 10px;
    padding: 6px 14px;
    font-size: 14px;
    background: #3D2412;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.filtro-box button:hover { background: #5a3820; }

.chart-container h2, .card h2 { color: #3D2412; margin-bottom: 20px; text-transform: uppercase; }

/* botão voltar */
.seta {
    width: 50px;
    height: 40px;
    position: absolute;
    top: 1300px;
    left: 20px;
}
</style>
</head>
<body>
<div class="dashboard">

<!-- FILTROS -->
<div class="filtros">
    <!-- Receita Mensal -->
    <form method="get" class="filtro-box">
        <h3><i class="ri-bar-chart-line"></i> Receita Mensal</h3>
        <label for="ano"><b>Ano:</b></label><br>
        <input list="anos" name="ano" id="ano" value="<?= $anoSelecionado ?>" placeholder="Escolha ano">
        <datalist id="anos">
            <?php foreach($anosDisponiveis as $ano): ?>
                <option value="<?= $ano ?>"></option>
            <?php endforeach; ?>
        </datalist>
        <button type="submit">Filtrar</button>
    </form>

    <!-- Pagamentos e Produtos -->
    <form method="get" class="filtro-box">
        <h3><i class="ri-shopping-cart-line"></i> Pagamentos & Produtos</h3>
        <label for="mes"><b>Mês:</b></label><br>
        <input list="meses" name="mes" id="mes" value="<?= $mesSelecionado ?>" placeholder="Escolha mês">
        <datalist id="meses">
            <?php foreach($mesesFormatados as $m): ?>
                <option value="<?= $m['valor'] ?>"><?= $m['texto'] ?></option>
            <?php endforeach; ?>
        </datalist>
        <button type="submit">Filtrar</button>
    </form>
</div>

<!-- GRÁFICO DE RECEITA MENSAL -->
<div class="chart-container">
  <h2>Receita Mensal (<?= $anoSelecionado ?>)</h2>
  <canvas id="graficoReceita"></canvas>
</div>

<!-- GRÁFICOS LADO A LADO -->
<div class="cards-horizontal">
  <div class="card large-card">
    <h2>Formas de Pagamento (<?= $tituloPagProd ?>)</h2>
    <canvas id="graficoPag"></canvas>
  </div>

  <div class="card large-card">
    <h2>Top 5 Produtos Mais Vendidos (<?= $tituloPagProd ?>)</h2>
    <canvas id="graficoTop"></canvas>
  </div>
</div>

<!-- BOTÃO VOLTAR -->
<a href="../inicio/home.php"> 
    <img class="seta" src="../img/btn_voltar.png" title="Voltar">
</a>

<script>
// -------- RECEITA MENSAL --------
const ctxReceita = document.getElementById('graficoReceita').getContext('2d');
const gradient = ctxReceita.createLinearGradient(0,0,0,400);
gradient.addColorStop(0,'rgba(189,142,110,0.6)');
gradient.addColorStop(1,'rgba(189,142,110,0.1)');

new Chart(ctxReceita, {
    type:'line',
    data:{
        labels: <?= json_encode($labelsM) ?>,
        datasets:[{
            label:'Receita R$',
            data: <?= json_encode($valuesM) ?>,
            borderColor:'#3D2412',
            backgroundColor: gradient,
            fill:true,
            tension:0.4,
            pointRadius:6,
            pointBackgroundColor:'#3D2412'
        }]
    },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:true}, tooltip:{enabled:true}}, scales:{y:{beginAtZero:true}, x:{ticks:{autoSkip:false}}} }
});

// -------- FORMAS DE PAGAMENTO --------
new Chart(document.getElementById('graficoPag'), {
    type:'pie',
    data:{
        labels: <?= json_encode($labelsP) ?>,
        datasets:[{
            data: <?= json_encode($valuesP) ?>,
            backgroundColor: <?= json_encode($coresFixas) ?>,
            borderColor:'#fff',
            borderWidth:2
        }]
    },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{position:'bottom', labels:{padding:20}}, tooltip:{enabled:true}} }
});

// -------- TOP 5 PRODUTOS --------
new Chart(document.getElementById('graficoTop'), {
    type:'bar',
    data:{
        labels: <?= json_encode($labelsT) ?>,
        datasets:[{
            label:'Qtd Vendida',
            data: <?= json_encode($valuesT) ?>,
            backgroundColor: <?= json_encode($coresTop) ?>,
            borderRadius:6
        }]
    },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}, tooltip:{enabled:true}}, scales:{y:{beginAtZero:true}, x:{ticks:{autoSkip:false}}} }
});
</script>
</body>
</html>
