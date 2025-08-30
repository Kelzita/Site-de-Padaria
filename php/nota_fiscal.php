<?php
require_once "conexao.php";

$id_comanda = $_GET['id'] ?? null;

if (!$id_comanda) {
    echo "ID da comanda inválido!";
    exit;
}

// Buscar comanda
$stmt = $pdo->prepare("SELECT * FROM comanda WHERE id_comanda = :id");
$stmt->execute(['id' => $id_comanda]);
$comanda = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comanda) {
    echo "Comanda não encontrada!";
    exit;
}

// Buscar itens da comanda com os dados do produto
$stmtItens = $pdo->prepare("
    SELECT ic.id_item_comanda, ic.quantidade, ic.total, p.nome_produto, p.preco
    FROM item_comanda ic
    JOIN produto p ON ic.id_produto = p.id_produto
    WHERE ic.id_comanda = :id
");
$stmtItens->execute(['id' => $id_comanda]);
$itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

// Calcular subtotal
$subtotal = 0;
foreach ($itens as $item) {
    $subtotal += $item['quantidade'] * $item['preco'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nota Fiscal - Comanda <?= $id_comanda ?></title>
 <style>
/* Base */
body {
  font-family: 'Times New Roman';
  margin: 20px;
  background-color: #f5f1eb;  margin: 0;
  padding: 0;
  height: 100%;
  width: 100%;
  font-family: 'Times New Roman';
  background-image: url('../img/fundo_padaria.png');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  min-height: 100vh;
  overflow-x: hidden; 
  color: #333;
}

.box_nf{
  background-color: white;
  margin: 20px 10px;
  width: 700px;
  height: 600px;
  border-radius: 10px;
  text-align: center; 
  float: center;
}

/* Título */
h2 {
    text-align: center;
    color: #3D2412;
    margin-bottom: 20px;
}

/* Informações da comanda */
p {
    font-size: 16px;
    margin: 5px;
    margin-right:5px;
}

/* Tabela */
table {
    width: 80%;
    text-align: center;
    border-collapse: collapse;
    margin: 20px auto; /* centraliza a tabela horizontalmente */
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
}

th {
    background-color: #3D2412;
    color: #fff;
    padding: 10px;
    text-align: left;
}

td {
    background-color: #fff;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

td.right {
    text-align: right;
}

/* Linhas alternadas da tabela */
tbody tr:nth-child(odd) td {
    background-color: #fdf7f0;
}

/* Subtotal */
.total {
    font-weight: bold;
    font-size: 1.3em;
    text-align: right;
    margin-top: 15px;
    color: #3D2412;
}

/* Rodapé */
.footer {
    text-align: center;
    margin-top: 30px;
}

/* Botão imprimir */
button {
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 8px;
    background-color: #5d331f;
    color: #fff;
    transition: 0.3s;
}

button:hover {
    background-color: #7a4226;
}

/* Responsivo simples */
@media print {
    button {
        display: none;
    }
    body {
        background-color: #fff;
        color: #000;
    }
}
</style>
</head>
<body>

<div class="box_nf">

<h2>Nota Fiscal - Comanda <?= htmlspecialchars($id_comanda) ?></h2>

<p><strong>Forma de Pagamento:</strong> <?= htmlspecialchars($comanda['forma_pagamento']) ?></p>
<p><strong>Status:</strong> <?= htmlspecialchars($comanda['status']) ?></p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Produto</th>
            <th>Qtd</th>
            <th>Valor Unit.</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($itens as $index => $item): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($item['nome_produto']) ?></td>
            <td><?= $item['quantidade'] ?></td>
            <td class="right">R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
            <td class="right">R$ <?= number_format($item['quantidade'] * $item['preco'], 2, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p class="total">Subtotal: R$ <?= number_format($subtotal, 2, ',', '.') ?></p>

<div class="footer">
    <p>Obrigado pela preferência! 🍞</p>
    <button onclick="window.print()">Imprimir Nota</button>
    <button onclick="window.close()">Voltar ao Caixa</button>
</div>

</div>
</body>
</html>

