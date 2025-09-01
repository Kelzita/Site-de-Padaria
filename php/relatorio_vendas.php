<?php
session_start();
require 'conexao.php';

// Conexão com banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$banco = "padaria_pao_genial";

try {
    $dsn = "mysql:host=$host;dbname=$banco;charset=utf8";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    die("<script>alert('Erro ao conectar-se ao banco');</script>" . $e->getMessage());
}

function fetchData($pdo, $sql, $params = []) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_NUM);
}

$receitaMensal = fetchData($pdo, "
    SELECT MONTH(c.data_abertura), SUM(ic.total)
    FROM comanda c
    JOIN item_comanda ic ON ic.id_comanda = c.id_comanda
    WHERE c.status='finalizado' AND YEAR(c.data_abertura) = YEAR(CURDATE())
    GROUP BY MONTH(c.data_abertura)
    ORDER BY MONTH(c.data_abertura)
");

$catReceitas = fetchData($pdo, "
    SELECT p.unmedida, SUM(ic.total)
    FROM item_comanda ic
    JOIN comanda c ON c.id_comanda = ic.id_comanda
    JOIN produto p ON p.id_produto = ic.id_produto
    WHERE c.status='finalizado' AND MONTH(c.data_abertura) = MONTH(CURDATE()) AND YEAR(c.data_abertura) = YEAR(CURDATE())
    GROUP BY p.unmedida
");

$pagamentos = fetchData($pdo, "
    SELECT c.forma_pagamento, COUNT(*) 
    FROM comanda c
    WHERE MONTH(c.data_abertura) = MONTH(CURDATE()) AND YEAR(c.data_abertura) = YEAR(CURDATE())
    GROUP BY c.forma_pagamento
");

$topProdutos = fetchData($pdo, "
    SELECT p.nome_produto, SUM(ic.quantidade)
    FROM item_comanda ic
    JOIN comanda c ON c.id_comanda = ic.id_comanda
    JOIN produto p ON p.id_produto = ic.id_produto
    WHERE MONTH(c.data_abertura) = MONTH(CURDATE()) AND YEAR(c.data_abertura) = YEAR(CURDATE())
    GROUP BY p.nome_produto
    ORDER BY SUM(ic.quantidade) DESC
    LIMIT 5
");

function arr_tar($data) {
    $labels = array_map('strval', array_column($data, 0));
    $vals = array_map('floatval', array_column($data, 1));
    return [$labels, $vals];
}

list($labelsM, $valuesM) = arr_tar($receitaMensal);
list($labelsC, $valuesC) = arr_tar($catReceitas);
list($labelsP, $valuesP) = arr_tar($pagamentos);
list($labelsT, $valuesT) = arr_tar($topProdutos);

function quickchartUrl($type, $labels, $data, $labelText='') {
    if (empty($labels) || empty($data)) {
        $labels = ['Nenhum dado'];
        $data = [0];
    }
    $config = [
        'type' => $type,
        'data' => [
            'labels' => $labels,
            'datasets' => [['label' => $labelText, 'data' => $data]]
        ],
        'options' => [
            'plugins' => [
                'legend' => ['display' => true]
            ]
        ]
    ];
    $json = urlencode(json_encode($config));
    return "https://quickchart.io/chart?c={$json}&w=600&h=400&devicePixelRatio=2";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Relatório Mensal</title>
<style>
body {
    /* Ajuste aqui o caminho para a imagem fundo.png */
    background-image: url('img/fundo.png'); /* ajuste conforme a localização do arquivo */
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
}

/* Resto do seu CSS */
.dashboard {
    position: relative; 
    padding-top: 20px; 
    max-width: 1100px;
    margin: auto;
}

.voltar {
    position: absolute;
    top: 30px;       
    left: 10px;     
    display: block;
    z-index: 10;     
    text-decoration: none;
    font-weight: bold;
    color: #34495e;
    font-size: 16px;
}

.chart-container {
    background: #ffffff;
    padding: 25px 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
}

.chart-container h2 {
    font-size: 1.4rem;
    color: #2c3e50;
    margin-bottom: 20px;
    text-align: center;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.chart-container img {
    max-height: 320px;
    display: block;
    margin: 0 auto;
}

.cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.card {
    background: #fff;
    flex: 1 1 300px;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.card h2 {
    font-size: 1.2rem;
    color: #2c3e50;
    margin-bottom: 18px;
    font-weight: 600;
    text-transform: uppercase;
}

.card img {
    max-height: 280px;
    display: block;
    margin: 0 auto;
}

.dashboard h2 {
    font-size: 1.5rem;
    color: #34495e;
    margin-bottom: 15px;
    font-weight: 700;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 1.2px;
}

.chart-container, .card {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: box-shadow 0.3s ease;
}

.chart-container:hover, .card:hover {
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}
</style>
</head>
<body>

<div class="dashboard">

<a href="#" class="voltar">&#8592; Voltar</a>

<div class="chart-container">
  <h2>RECEITA MENSAL</h2>
  <img src="<?= quickchartUrl('line', $labelsM, $valuesM, 'Receita R$'); ?>" alt="Receita Mensal">
</div>

<div class="cards">
  <div class="card">
    <h2>RECEITA POR CATEGORIA</h2>
    <img src="<?= quickchartUrl('bar', $labelsC, $valuesC, 'Receita por Unidade'); ?>" alt="Receita Categorias">
  </div>
  <div class="card">
    <h2>FORMAS DE PAGAMENTO</h2>
    <img src="<?= quickchartUrl('pie', $labelsP, $valuesP, 'Pagamentos'); ?>" alt="Formas de Pagamento">
  </div>
  <div class="card">
    <h2>TOP 5 PRODUTOS MAIS VENDIDOS</h2>
    <img src="<?= quickchartUrl('bar', $labelsT, $valuesT, 'Quantidade Vendida'); ?>" alt="Top Produtos">
  </div>
</div>

</div>

</body>
</html>
