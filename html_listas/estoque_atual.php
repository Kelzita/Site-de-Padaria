<?php 
include '../php/buscar_estoque.php';
require_once '../php/funcoes.php';
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/styletabela.css" />
    <title>Estoque Atual</title>
    <style>
        /* Linhas normais */
tr.ok td {
    background-color: #f9fff9;
    color: #222;
}

/* Linhas com alerta de baixo estoque */
tr.alerta td {
    background-color: #ffe5e5;
    color: #b30000;
    font-weight: bold;
}

/* Ícones de status alinhados */
td:last-child {
    text-align: center;
}

    </style>
</head>
<body>
<header>
    <img src="../img/logo.png" alt="logo" />
</header>

<div class="container">
    <h1>📦 Estoque Atual</h1>
    <h2>Status dos Produtos</h2>

    <?php if (!empty($produtosEstoque)) : ?>
    <table border="1" bgcolor="white">
        <thead>
        <tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($produtosEstoque as $produto) : 
            $qtd = (int)$produto['quantidade_produto'];
            $classe = $qtd <= 20 ? 'alerta' : 'ok';
            $status = $qtd <= 20 ? '⚠ Baixo Estoque' : '✅ OK';
        ?>
            <tr class="<?= $classe ?>">
                <td><?= htmlspecialchars($produto['id_produto']); ?></td>
                <td><?= htmlspecialchars($produto['nome_produto']); ?></td>
                <td><?= $qtd; ?></td>
                <td><?= $status; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table> 
    <?php else: ?>
        <p style="color:white;">Nenhum produto encontrado no estoque.</p>
    <?php endif; ?>
</div>
<a href="../inicio/home.php" class="voltar"> 
        <img class="seta" src="../img/btn_voltar.png" title="seta">
</a>
</body>
</html>
