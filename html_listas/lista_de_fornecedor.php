<?php 
include '../php/buscar_fornecedor.php'

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
    <title>Lista de Fornecedor</title>
</head>
<body>
    <header>
        <img src="../img/logo.png" alt="logo"/>
    </header>
<div class="container">
    <h1>Lista de Fornecedores</h1>
    <h2>Buscar Fornecedores</h2>
    <form action="lista_de_fornecedor.php" method="POST" class="search-form">
        <div class="input-container">
        <input type="text" id="busca" name="busca" placeholder="Insira a Busca por ID ou nome"/>
        <button type="submit"><i class="ri-search-line"></i></button>
    </div>
    </form>

    <?php if(!empty($fornecedores)) : ?>
    <table border="1" bgcolor="white">
        <tr>
            <th>Id</th>
            <th>Razão Social</th>
            <th>Responsável</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>CEP</th>  
            <th>Ações</th>  
        </tr>
        <?php foreach($fornecedores as $fornecedor) : ?>
        <tr>
            <td><?=htmlspecialchars($fornecedor['id_fornecedor']); ?></td>
            <td><?=htmlspecialchars($fornecedor['razao_social']); ?></td>
            <td><?=htmlspecialchars($fornecedor['responsavel']); ?></td>
            <td><?=htmlspecialchars($fornecedor['email_fornecedor']); ?></td>
            <td><?=htmlspecialchars($fornecedor['telefone_fornecedor']); ?></td>
            <td><?=htmlspecialchars($fornecedor['cep_fornecedor']); ?></td>
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
        <p style="color:white;">Nenhum fornecedor cadastrado.</p>
    <?php endif; ?>
</body>
</html>
