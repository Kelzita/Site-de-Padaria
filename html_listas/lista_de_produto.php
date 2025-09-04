<?php 
require_once '../php/conexao.php'; 
require_once '../php/buscar_produto.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/styletabela.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body>
<header>
    <img src="../img/logo.png" alt="Logo" />
</header>

<div class="container">
    <h1>Lista de Produtos</h1>
    <h2>Buscar Produto</h2>

    <form action="lista_de_produto.php" method="POST" class="search-form">
        <div class="input-container">
            <input type="text" id="busca" name="busca" placeholder="Insira a Busca (por ID ou nome)" />
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>

    <?php if (!empty($produtos)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Validade</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $p): ?>
            <tr>
                <td><?= $p['id_produto'] ?></td>
                <td><?= htmlspecialchars($p['nome_produto']); ?></td>
                <td><?= htmlspecialchars($p['validade']); ?></td>
                <td><?= htmlspecialchars($p['quantidade_produto']); ?></td>
                <td class="acoes">
                    <a href="#" onclick="abrirModalProduto(<?= $p['id_produto'] ?>)" class="acao" title="Visualizar">
                        <i class="ri-eye-line"></i>
                    </a>
                    <a href="../alteracoes/Alterar_Produto.php?id=<?= $p['id_produto'] ?>" class="acao" title="Alterar">
                        <i class="ri-edit-line"></i>
                    </a>
                    <a href="#" onclick="deletarProduto(<?= $p['id_produto'] ?>)" class="acao" title="Inativar">
                        <i class="ri-delete-bin-2-line"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="color:white;">Nenhum produto cadastrado.</p>
    <?php endif; ?>
</div>

<script>
function deletarProduto(id) {
    if(!confirm("Deseja realmente deletar este produto?")) return;
    const form = document.createElement('form');
    form.method = "POST";
    form.action = "../php/deletar_produto.php";
    const input = document.createElement('input');
    input.type = "hidden";
    input.name = "id_produto";
    input.value = id;
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}

function abrirModalProduto(id){
    fetch(`../php/modals/modal_produto.php?id=${id}`)
    .then(res => res.text())
    .then(html => {
        // Remove modal antigo se existir
        const antigo = document.querySelector('.modal-editar');
        if(antigo) antigo.remove();

        // Adiciona o novo modal
        document.body.insertAdjacentHTML('beforeend', html);

        // Seleciona o modal recém-inserido
        const modal = document.querySelector('.modal-editar');

        // Fechar clicando fora do container
        modal.addEventListener('click', (e) => {
            if (!e.target.closest('.modal-editar__container')) {
                modal.remove();
            }
        });

        // Fechar clicando no botão "×"
        const btnFechar = modal.querySelector('.modal-editar__fechar');
        if(btnFechar){
            btnFechar.addEventListener('click', () => {
                modal.remove();
            });
        }
    })
    .catch(err => console.error(err));
}

</script>
</body>
</html>
