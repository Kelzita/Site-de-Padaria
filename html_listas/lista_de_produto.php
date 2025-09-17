<?php 
require_once '../php/conexao.php'; 
require_once '../php/buscar_produto.php'; 
require_once '../php/menu.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Produtos</title>
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/stylehome.css">
<link rel="stylesheet" href="../css/styletabela.css" />
<link rel="stylesheet" href="../css/modal.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
<link rel="icon" href="img/logo_title.png">
<style>
/* Alertas de baixo estoque */
td.alerta {
    background-color: #ffe5e5;
    color: #b30000;
    font-weight: bold;
}

/* Estoque normal */
td.ok {
    background-color: #f9fff9;
    color: #222;
}
</style>
</head>
<body>

<div class="container">
    <h1>Lista de Produtos</h1>

    <!-- Formulário de busca -->
    <form action="lista_de_produto.php" method="POST" class="search-form" id="formBusca">
        <div class="input-container">
            <input type="text" id="busca" name="busca" placeholder="Insira a Busca (por ID ou nome)" />
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
    <p id="erroBusca" style="color: red;"></p>

    <!-- Filtro de status -->
    <div class="select">
        <select id="filtro-status" name="status">
            <option value="">Todos</option>
            <option value="1">Ativos</option>
            <option value="0">Inativos</option>
        </select>
    </div>

    <?php if (!empty($produtos)): ?>
    <table id="tabela-produtos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Validade</th>
                <th>Quantidade</th>
                <th>Status / Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $p): 
                $qtd = (int)$p['quantidade_produto'];
                $classeEstoque = $qtd <= 20 ? 'alerta' : 'ok';
                $statusEstoque = $qtd <= 20 ? '⚠ Baixo Estoque' : '✅';
            ?>
            <tr data-status="<?= $p['ativo'] ?>">
                <td><?= $p['id_produto'] ?></td>
                <td><?= htmlspecialchars($p['nome_produto']); ?></td>
                <td><?= htmlspecialchars($p['validade']); ?></td>
                <td><?= htmlspecialchars($p['quantidade_produto']); ?></td>
                <td class="status <?= $classeEstoque ?>">
                    <?= $p['ativo'] ? 'Ativo' : 'Inativo' ?><br>
                    <?= $statusEstoque ?>
                </td>
                <td class="acoes">
                    <!-- Visualizar -->
                    <a href="#" onclick="abrirModalProduto(<?= $p['id_produto'] ?>)" class="acao" title="Visualizar">
                        <i class="ri-eye-line"></i>
                    </a>
                    <!-- Alterar -->
                    <a href="../alteracoes/Alterar_Produto.php?id=<?= $p['id_produto'] ?>" class="acao" title="Alterar">
                        <i class="ri-edit-line"></i>
                    </a>
                    <!-- Ativar/Inativar -->
                    <a href="#" class="acao btn-toggle" onclick="toggleAtivoProduto(this, <?= $p['id_produto'] ?>)">
                        <i class="<?= $p['ativo'] ? 'ri-checkbox-circle-line' : 'ri-close-circle-line' ?>"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="margin-top: 10px; color:white;">Nenhum produto cadastrado.</p>
    <?php endif; ?>
</div>

<a href="../inicio/home.php" class="voltar"> 
    <img class="seta" src="../img/btn_voltar.png" title="seta">
</a>

<script>
// ====== Modal Visualizar ======
function abrirModalProduto(id){
    fetch(`../php/modals/modal_produto.php?id=${id}`)
    .then(res => res.text())
    .then(html => {
        const antigo = document.querySelector('.modal');
        if(antigo) antigo.remove();
        document.body.insertAdjacentHTML('beforeend', html);

        const modal = document.querySelector('.modal');

        modal.addEventListener('click', (e) => {
            if (!e.target.closest('.modal-container')) modal.remove();
        });

        const btnFechar = modal.querySelector('.modal-close');
        if (btnFechar) btnFechar.addEventListener('click', () => modal.remove());
    })
    .catch(err => console.error(err));
}

// ====== Ativar/Inativar Produto ======
function toggleAtivoProduto(element, id) {
    if (!confirm('Deseja realmente alterar o status deste produto?')) return;

    fetch('../php/inativar_produto.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id_produto=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if(data.sucesso) {
            const tr = element.closest('tr');
            const statusCell = tr.querySelector('.status');
            const icone = element.querySelector('i');

            if(data.ativo) {
                statusCell.innerHTML = 'Ativo<br>' + statusCell.textContent.split('<br>')[1];
                icone.classList.remove('ri-close-circle-line');
                icone.classList.add('ri-checkbox-circle-line');
                tr.dataset.status = 1;
                alert('Produto ativado com sucesso!');
            } else {
                statusCell.innerHTML = 'Inativo<br>' + statusCell.textContent.split('<br>')[1];
                icone.classList.remove('ri-checkbox-circle-line');
                icone.classList.add('ri-close-circle-line');
                tr.dataset.status = 0;
                alert('Produto inativado com sucesso!');
            }
        } else {
            alert('Erro: ' + (data.erro || 'Não foi possível alterar o status.'));
        }
    })
    .catch(err => {
        console.error(err);
        alert('Erro no servidor ao alterar produto!');
    });
}

// ====== Filtro Ativos/Inativos via select ====== 
document.getElementById('filtro-status').addEventListener('change', function(){
    const status = this.value; 
    document.querySelectorAll('#tabela-produtos tbody tr').forEach(tr => { 
        tr.style.display = (status === '' || tr.dataset.status === status) ? '' : 'none'; 
    }); 
});
</script>

</body>
</html>
