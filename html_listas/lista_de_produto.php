<?php 
require_once '../php/buscar_produto.php'; 
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
    
    <title>Lista de Produtos</title>
</head>
<body>
<header>
    <img src="../img/logo.png" alt="Logo" />
</header>

<div class="container">
    <h1>Lista de Produtos</h1>
    <h2>Buscar Funcionário</h2>
    <!-- Formulário de busca -->
    <form action="lista_de_produto.php" method="POST" class="search-form">
        <div class="input-container">
            <input type="text" id="busca" name="busca" placeholder="Insira a Busca (por ID ou nome)" />
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>

    <?php if (!empty($produtos)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome do Produto</th>
                    <th>Validade</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto) : ?>
                    <tr>
                        <td><?= htmlspecialchars($produto['id_produto']); ?></td>
                        <td><?= htmlspecialchars($produto['nome_produto']); ?></td>
                        <td><?= htmlspecialchars($produto['validade']); ?></td>
                        <td><?= htmlspecialchars($produto['quantidade_produto']); ?></td>
                        <td class="acoes">
                            <!-- Botão de visualizar -->
                            <a href="#" onclick="abrirModalProduto(<?= $produto['id_produto']; ?>)" class="acao" title="Visualizar">
                            <i class="ri-eye-line"></i>
                            </a>

                            <!-- Botão de alterar -->
                            <a href="../alteracoes/Alterar_Produto.php?id=<?= $produto['id_produto']; ?>" class="acao" title="Alterar">
                                <i class="ri-edit-line"></i>
                            </a>

                            <!-- Botão de inativar -->
                            <a href="#" class="acao" onclick="deletarProduto(<?= $produto['id_produto'] ?>)">
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
function abrirModalProduto(id){
    fetch(`../php/modals/modal_produto.php?id=${id}`)
    .then(res => res.text())
    .then(html => {
        // Remove qualquer modal antigo
        const antigo = document.querySelector('.modal-editar');
        if(antigo) antigo.remove();

        // Adiciona diretamente no body
        document.body.insertAdjacentHTML('beforeend', html);
    })
    .catch(err => console.error(err));
}

// Delegação de eventos para fechar modal
document.addEventListener('click', function(e){
    const modal = e.target.closest('.modal-editar');
    if(!modal) return;

    // Clicar fora do container fecha
    if(!e.target.closest('.modal-editar__container')) {
        modal.remove();
    }

    // Clicar no "×" fecha
    if(e.target.classList.contains('modal-editar__fechar')){
        modal.remove();
    }
});


function deletarProduto(id_produto) {
    if (!confirm('Tem certeza que deseja deletar este produto?')) return;

    // Cria um formulário dinamicamente
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../php/deletar_produto.php';

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'id_produto';
    input.value = id_produto;

    form.appendChild(input);
    document.body.appendChild(form);

    form.submit();
}
</script>

</body>
</html>
