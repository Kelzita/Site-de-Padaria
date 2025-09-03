<?php 
require_once '../php/buscar_funcionario.php';
require_once '../php/modals_funcionarios.php';



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
    <title>Lista de Funcionários</title>
</head>
<body>
    <header>
        <img src="../img/logo.png"/>
    </header>
    <div class="container">
    <h1>Lista de Funcionários</h1>
    <h2>Buscar Funcionário</h2>
    <form action="lista_de_funcionarios.php" method="POST" class="search-form">
        <div class="input-container">
        <input type="text" id="busca" name="busca" placeholder="Insira a Busca (por ID ou nome )"/>
        <button type="submit"><i class="ri-search-line"></i></button>
    </div>
    </form>

    <?php if(!empty($funcionarios)) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>CPF</th>
                <th>Função</th>
                <th>Senha</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            <?php foreach($funcionarios as $funcionario) :?>
            <tr>
                <td><?=htmlspecialchars($funcionario['id_funcionario']); ?></td>
                <td><?=htmlspecialchars($funcionario['nome_funcionario']); ?></td>
                <td><?=htmlspecialchars($funcionario['email_funcionario']); ?></td>
                <td><?=htmlspecialchars($funcionario['cpf_funcionario']); ?></td>
                <td><?=htmlspecialchars($funcionario['nome_funcao']); ?></td>
                <td><?= substr($funcionario['senha'], 0, 4) . '…' ?></td>
                <td><?=htmlspecialchars($funcionario['ativo']); ?></td>

                <td> 
                    
                <a href="#" class="visualizarfuncionario" 
                    data-foto="<?= htmlspecialchars($funcionario['imagem_funcionario']) ?>"
                    data-id_funcionario="<?=htmlspecialchars($funcionario['id_funcionario']); ?>"
                    data-nome_funcionario="<?=htmlspecialchars($funcionario['nome_funcionario']); ?>"
                    data-cpf_funcionario="<?=htmlspecialchars($funcionario['cpf_funcionario']); ?>"
                    data-email_funcionario="<?=htmlspecialchars($funcionario['email_funcionario']); ?>"
                    data-senha="<?=substr($funcionario['senha'], 0, 10) . '…' ; ?>"
                    data-telefone_funcionario="<?=htmlspecialchars($funcionario['telefone_funcionario']); ?>"
                    data-cep_funcionario="<?=htmlspecialchars($funcionario['cep_funcionario']); ?>"
                    data-rua_funcionario="<?=htmlspecialchars($funcionario['rua_funcionario']); ?>"
                    data-numero_funcionario="<?=htmlspecialchars($funcionario['numero_funcionario']); ?>"
                    data-bairro_funcionario="<?=htmlspecialchars($funcionario['bairro_funcionario']); ?>"
                    data-cidade_funcionario="<?=htmlspecialchars($funcionario['cidade_funcionario']); ?>"
                    data-uf_funcionario="<?=htmlspecialchars($funcionario['uf_funcionario']); ?>"
                    data-data_admissao="<?=htmlspecialchars($funcionario['data_admissao']); ?>"
                    data-salario="<?=htmlspecialchars($funcionario['salario']); ?>"
                    data-id_funcao="<?=htmlspecialchars($funcionario['id_funcao']) . ' - ' . htmlspecialchars($funcionario['nome_funcao']); ?>">Visualizar</a>

                    <a href="#" class="alterarfuncionario" 
                        data-foto="<?=htmlspecialchars($funcionario['imagem_funcionario']);?>"
                        data-id_funcionario="<?=htmlspecialchars($funcionario['id_funcionario']); ?>"
                        data-nome_funcionario="<?=htmlspecialchars($funcionario['nome_funcionario']); ?>"
                        data-cpf_funcionario="<?=htmlspecialchars($funcionario['cpf_funcionario']); ?>"
                        data-email_funcionario="<?=htmlspecialchars($funcionario['email_funcionario']); ?>"
                        data-senha="<?=htmlspecialchars($funcionario['senha']); ?>"
                        data-telefone_funcionario="<?=htmlspecialchars($funcionario['telefone_funcionario']); ?>"
                        data-cep_funcionario="<?=htmlspecialchars($funcionario['cep_funcionario']); ?>"
                        data-rua_funcionario="<?=htmlspecialchars($funcionario['rua_funcionario']); ?>"
                        data-numero_funcionario="<?=htmlspecialchars($funcionario['numero_funcionario']); ?>"
                        data-bairro_funcionario="<?=htmlspecialchars($funcionario['bairro_funcionario']); ?>"
                        data-cidade_funcionario="<?=htmlspecialchars($funcionario['cidade_funcionario']); ?>"
                        data-uf_funcionario="<?=htmlspecialchars($funcionario['uf_funcionario']); ?>"
                        data-data_admissao="<?=htmlspecialchars($funcionario['data_admissao']); ?>"
                        data-salario="<?=htmlspecialchars($funcionario['salario']); ?>"
                        data-id_funcao="<?=htmlspecialchars($funcionario['id_funcao']); ?>"
                        data-nome_funcao="<?=htmlspecialchars($funcionario['nome_funcao']); ?>">Alterar</a>
        
                    <a>Inativar</a>
                    
        
                </td>
            </tr>
            <?php endforeach; ?>
         </table>
         <?php else: ?>
        <p>Nenhum funcionário cadastrado.</p>
         <?php endif; ?>   
</body>
</html>