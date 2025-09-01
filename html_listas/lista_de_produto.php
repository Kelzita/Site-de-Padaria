<?php 
include '../php/buscar_produto.php'

?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css"/>
    <link rel="stylesheet" href="../css/styletabela.css"/>
    <title>Lista de Produto</title>
</head>
<body>
    <header>
        <img src="../img/logo.png" alt="logo"/>
    </header>
<div class="container">
    <h1>Lista de Produtos</h1>
    <h2>Buscar Produtos</h2>
    <form action="lista_de_produto.php" method="POST" class="search-form">
        <div class="input-container">
        <input type="text" id="busca" name="busca" placeholder="Insira a Busca por ID ou nome"/>
        <button type="submit"><i class="ri-search-line"></i></button>
    </div>
    </form>

    <?php if(!empty($produtos)) : ?>
    <table border="1" bgcolor="white">
        <tr>
            <th>Id</th>
            <th>Nome do Produto</th>
            <th>Validade</th>
            <th>Quantidade</th>  
            <th>Ações</th>  
        </tr>
        <?php foreach($produtos as $produto) : ?>
        <tr>
            <td><?=htmlspecialchars($produto['id_produto']); ?></td>
            <td><?=htmlspecialchars($produto['nome_produto']); ?></td>
            <td><?=htmlspecialchars($produto['validade']); ?></td>
            <td><?=htmlspecialchars($produto['quantidade_produto']); ?></td>
            
            <td>
                <a>Visualizar</a>
                <a>Deletar</a>
                <a>Alterar</a>
            </td>
        </tr>
        <?php endforeach;?>
    </table> 
<div>
    <?php else: ?>
        <p style="color:white;">Nenhum produto cadastrado.</p>
    <?php endif; ?>
</body>
</html>
