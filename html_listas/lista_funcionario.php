<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css"/>
    <link rel="stylesheet" href="../css/stylefuncionarios.css"/>
    <title>Lista de Funcionários</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>
    <header>
        <img src="../img/logo.png" alt="Logo">
    </header>

    <div class="container">
        <h1>Lista de Funcionários</h1>

        <div class="search-section">
            <h2>Buscar Funcionários</h2>
            <form class="barra-pesquisa" action="../php/lista_funcionario_buscar.php" method="POST">
                <input type="text" name="buscar_funcionario" id="buscar_funcionario" placeholder="Nome ou ID do Funcionário"/>
                 <button type="submit"><i class="fas fa-magnifying-glass"></i></button>
         </form>
        </div>
        <?php if(!empty($funcionarios)) : ?>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Senha</th>
        <th>Função</th>
        <th>Ações</th>
    </tr>
    <?php foreach($funcionarios as $funcionario) : ?>
    <tr>
        <td><?= htmlspecialchars($funcionario['id_funcionario']); ?></td>
        <td><?= htmlspecialchars($funcionario['nome_funcionario']); ?></td>
        <td><?= htmlspecialchars($funcionario['email_funcionario']); ?></td>
        <td><?= htmlspecialchars($funcionario['telefone_funcionario']); ?></td>
        <td><?= htmlspecialchars($funcionario['senha']); ?></td>
        <td><?= htmlspecialchars($funcionario['nome_funcao']); ?></td>
        <td>
            <a href="editar.php?id=<?= $funcionario['id_funcionario'] ?>">Editar</a> |
            <a href="deletar.php?id=<?= $funcionario['id_funcionario'] ?>">Deletar</a>
        </td>
    </tr>
    <?php endforeach ?>
</table>
<?php else : ?>
    <p>Nenhum funcionário encontrado</p>
<?php endif; ?>

    </div>
</body>
</html>
