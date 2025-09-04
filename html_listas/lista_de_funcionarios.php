<?php 
require_once '../php/buscar_funcionario.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- CSS -->
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/modal.css" />
    <link rel="stylesheet" href="../css/styletabela.css" />
    
    <!-- Ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
    
    <title>Lista de Funcionários</title>
</head>
<body>
<header>
    <img src="../img/logo.png" alt="Logo" />
</header>

<div class="container">
    <h1>Lista de Funcionários</h1>
    <h2>Buscar Funcionário</h2>
    
    <!-- Formulário de busca -->
    <form action="lista_de_funcionarios.php" method="POST" class="search-form">
        <div class="input-container">
            <input type="text" id="busca" name="busca" placeholder="Insira a Busca (por ID ou nome)" />
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>

    <?php if (!empty($funcionarios)) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($funcionarios as $funcionario) : ?>
                    <tr>
                        <td><?= htmlspecialchars($funcionario['id_funcionario']); ?></td>
                        <td><?= htmlspecialchars($funcionario['nome_funcionario']); ?></td>
                        <td><?= htmlspecialchars($funcionario['email_funcionario']); ?></td>
                        <td><?= htmlspecialchars($funcionario['telefone_funcionario']); ?></td>
                        <td class="acoes">
                            <!-- Visualizar -->
                            <a href="#" onclick="abrirModalFuncionario(<?= $funcionario['id_funcionario']; ?>)" class="acao" title="Visualizar">
                                <i class="ri-eye-line"></i>
                            </a>
                            <!-- Alterar -->
                            <a href="../alteracoes/Alterar_Funcionario.php?id=<?= $funcionario['id_funcionario']; ?>" class="acao" title="Alterar">
                                <i class="ri-edit-line"></i>
                            </a>
                            <!-- Inativar -->
                            <a href="#" class="acao" onclick="inativarFuncionario(<?= $funcionario['id_funcionario'] ?>)">
                                <i class="ri-delete-bin-2-line"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color:white;">Nenhum funcionário cadastrado.</p>
    <?php endif; ?>
</div>

<script>
function abrirModalFuncionario(id){
    fetch(`../php/modals/modal_funcionario.php?id=${id}`)
    .then(res => res.text())
    .then(html => {
        const antigo = document.querySelector('.modal-editar');
        if(antigo) antigo.remove();
        document.body.insertAdjacentHTML('beforeend', html);
    })
    .catch(err => console.error(err));
}

document.addEventListener('click', function(e){
    const modal = e.target.closest('.modal-editar');
    if(!modal) return;

    if(!e.target.closest('.modal-editar__container')) {
        modal.remove();
    }
    if(e.target.classList.contains('modal-editar__fechar')){
        modal.remove();
    }
});

function inativarFuncionario(id) {
    if (!confirm('Tem certeza que deseja inativar este funcionário?')) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../php/inativar_funcionario.php';

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'id_funcionario';
    input.value = id;

    form.appendChild(input);
    document.body.appendChild(form);

    form.submit();
}
</script>

</body>
</html>
