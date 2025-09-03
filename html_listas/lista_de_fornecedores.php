<?php 
include '../php/buscar_fornecedor.php';
include '../php/modals.php';

?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/jquery.inputmask.min.js"></script>
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
    <form action="lista_de_fornecedores.php" method="POST" class="search-form">
        <div class="input-container">
        <input type="text" id="busca" name="busca" placeholder="Insira a Busca (por ID ou nome)"/>
        <button type="submit"><i class="ri-search-line"></i></button>
    </div>
    </form>

    <?php if(!empty($fornecedores)) : ?>
    <table>
        <tr>
            <th>ID</th>
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
                <a href="#" class="visualizar" data-id="<?=htmlspecialchars($fornecedor['id_fornecedor']); ?>"
                    data-razao_social="<?= $fornecedor['razao_social'] ?>"
                    data-responsavel="<?= $fornecedor['responsavel'] ?>"
                    data-cnpj_fornecedor="<?= $fornecedor['cnpj_fornecedor'] ?>"
                    data-email_fornecedor="<?= $fornecedor['email_fornecedor'] ?>"
                    data-telefone_fornecedor="<?= $fornecedor['telefone_fornecedor'] ?>"
                    data-cep_fornecedor="<?= $fornecedor['cep_fornecedor'] ?>"
                    data-rua_fornecedor="<?= $fornecedor['rua_fornecedor'] ?>"
                    data-numero_fornecedor="<?= $fornecedor['numero_fornecedor'] ?>"
                    data-bairro_fornecedor="<?= $fornecedor['bairro_fornecedor'] ?>"
                    data-cidade_fornecedor="<?= $fornecedor['cidade_fornecedor'] ?>"
                    data-uf_fornecedor="<?= $fornecedor['uf_fornecedor'] ?>"
                >Visualizar</a>
                <a href="#" class="alterar" 
                    data-id="<?= htmlspecialchars($fornecedor['id_fornecedor']); ?>"
                    data-razao_social="<?= $fornecedor['razao_social'] ?>"
                    data-responsavel="<?= $fornecedor['responsavel'] ?>"
                    data-cnpj_fornecedor="<?= $fornecedor['cnpj_fornecedor'] ?>"
                    data-email_fornecedor="<?= $fornecedor['email_fornecedor'] ?>"
                    data-telefone_fornecedor="<?= $fornecedor['telefone_fornecedor'] ?>"
                    data-cep_fornecedor="<?= $fornecedor['cep_fornecedor'] ?>"
                    data-rua_fornecedor="<?= $fornecedor['rua_fornecedor'] ?>"
                    data-numero_fornecedor="<?= $fornecedor['numero_fornecedor'] ?>"
                    data-bairro_fornecedor="<?= $fornecedor['bairro_fornecedor'] ?>"
                    data-cidade_fornecedor="<?= $fornecedor['cidade_fornecedor'] ?>"
                    data-uf_fornecedor="<?= $fornecedor['uf_fornecedor'] ?>"
                >Alterar</a>
                <a>Deletar</a>
            </td>
        </tr>
        <?php endforeach;?>
    </table> 
    <?php else: ?>
        <p>Nenhum fornecedor cadastrado.</p>
    <?php endif; ?>
</body>
</html>
