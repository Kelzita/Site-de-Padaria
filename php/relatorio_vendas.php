<?php
session_start();
require_once("conexao.php");
require_once("menu.php");

// ==================== FUNÇÕES ==================== //

// Função genérica para buscar dados
function fetchData($pdo, $sql, $params = []) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_NUM);
}

// Organiza dados para gráfico, ignorando meses futuros
function arr_tar($data, $tipoMes = false) {
    $labels = [];
    $vals = [];

    // Mês atual
    $mesAtual = (int)date('n');

    foreach ($data as $row) {
        $mes = $row[0];
        if($tipoMes && $mes > $mesAtual) continue; // ignora meses futuros

        $labels[] = $tipoMes ? ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'][$mes-1] : $row[0];
        $vals[] = (float)$row[1];
    }

    return [$labels,$vals];
}

// Monta URL do QuickChart
function quickchartUrl($type, $labels, $data, $labelText='', $colors=[]) {
    if(empty($labels)) $labels=['Sem dados'];
    if(empty($data)) $data=[0];
    if(empty($colors)) $colors=array_fill(0,count($labels),'#3D2412');

    $dataset = ['label'=>$labelText,'data'=>$data];
    if($type==='pie' || $type==='bar') $dataset['backgroundColor'] = $colors;
    if($type==='line'){ $dataset['borderColor'] = $colors[0]; $dataset['fill'] = false; }

    $config = ['type'=>$type,'data'=>['labels'=>$labels,'datasets'=>[$dataset]],'options'=>['plugins'=>['legend'=>['display'=>true]]]];

    return "https://quickchart.io/chart?c=".urlencode(json_encode($config))."&w=600&h=400&devicePixelRatio=2";
}

// ==================== CONSULTAS ==================== //

// 1) Receita Mensal
$receitaMensal = fetchData($pdo, "
    SELECT MONTH(c.data_fechamento), COALESCE(SUM(ic.total),0)
    FROM comanda c
    JOIN item_comanda ic ON ic.id_comanda = c.id_comanda
    WHERE LOWER(c.status)='fechada' AND YEAR(c.data_fechamento) = YEAR(CURDATE())
    GROUP BY MONTH(c.data_fechamento)
    ORDER BY MONTH(c.data_fechamento)
");

// 2) Formas de Pagamento
$formasFixas = ['dinheiro','pix','cartao de debito','cartao de credito','vale alimentação'];
$coresFixas = ['#3D2412','#B88C6D','#F5E6C7','#A67B5B','#CBAE8B'];

$pagamentosRaw = fetchData($pdo, "
    SELECT LOWER(c.forma_pagamento) AS forma, COUNT(*) AS total
    FROM comanda c
    WHERE LOWER(c.status)='fechada'
      AND MONTH(c.data_fechamento)=MONTH(CURDATE())
      AND YEAR(c.data_fechamento)=YEAR(CURDATE())
    GROUP BY LOWER(c.forma_pagamento)
");

$pagamentosAssoc = [];
foreach($pagamentosRaw as $p){
    $pagamentosAssoc[$p[0]] = (int)$p[1];
}

$labelsP = $formasFixas;
$valuesP = [];
foreach($formasFixas as $f){
    $valuesP[] = $pagamentosAssoc[$f] ?? 0;
}
$coresPag = $coresFixas;

// 3) Top 5 Produtos Mais Vendidos (somente produtos reais)
$topProdutos = fetchData($pdo, "
    SELECT p.nome_produto, COALESCE(SUM(ic.quantidade),0) AS total_vendido
    FROM item_comanda ic
    JOIN comanda c ON c.id_comanda = ic.id_comanda
    JOIN produto p ON p.id_produto = ic.id_produto
    WHERE LOWER(c.status)='fechada'
      AND MONTH(c.data_fechamento)=MONTH(CURDATE())
      AND YEAR(c.data_fechamento)=YEAR(CURDATE())
    GROUP BY p.id_produto
    ORDER BY total_vendido DESC
    LIMIT 5
");

list($labelsM,$valuesM) = arr_tar($receitaMensal,true);
list($labelsT,$valuesT) = arr_tar($topProdutos);
$coresTop=['#3D2412','#B88C6D','#F5E6C7','#A67B5B','#CBAE8B'];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Relatórios Dashboard</title>
<style>
body {
    font-family: 'Times New Roman', serif;
    background-image:url('../img/fundo_padaria.png');
    background-size:cover;
    margin:0;
    display:flex;
    flex-direction:column;
    align-items:center;
}
.dashboard{ max-width:1100px; 
width:100%; 
margin-top:80px;}
.chart-container, .card{
    background-color:rgba(255,255,255,0.85);
    border-radius:10px;
    padding:20px;
    margin-bottom:30px;
    text-align:center;
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
}
.cards{ 
display:flex; 
flex-wrap:wrap; gap:20px; 
justify-content:center;
}
.chart-container h2, .card h2{ 
color:#3D2412; margin-bottom:20px; 
text-transform:uppercase; 
}
img{ 
max-height:320px; 
display:block; 
margin:0 auto;
}
.voltar{ 
display:block; 
text-decoration:none; 
color:#3D2412; 
font-weight:bold; 
margin-bottom:20px;
}
.seta{
width: 50px ;
height: 40px ;
margin-top: 20px;
margin-left: -650px;
left: 5px;
}
</style>
<link rel="stylesheet" href="../css/stylehome.css"/>
</head>
<body>
<div class="dashboard">
<div class="chart-container">
  <h2>RECEITA MENSAL</h2>
  <img src="<?= quickchartUrl('line',$labelsM,$valuesM,'Receita R$',['#3D2412']); ?>" alt="Receita Mensal">
</div>

<div class="cards">
  <div class="card">
    <h2>FORMAS DE PAGAMENTO</h2>
    <img src="<?= quickchartUrl('pie',$labelsP,$valuesP,'Pagamentos',$coresPag); ?>" alt="Formas de Pagamento">
  </div>
  <div class="card">
    <h2>TOP 5 PRODUTOS MAIS VENDIDOS</h2>
    <img src="<?= quickchartUrl('bar',$labelsT,$valuesT,'',$coresTop); ?>" alt="Top Produtos">
  </div>
</div>
</div>
  <a href="../inicio/home.php" class="voltar"> 
        <img class="seta" src="../img/btn_voltar.png" title="seta">
  </a>
</body>
</html>
