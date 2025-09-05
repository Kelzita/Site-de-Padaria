<?php 
require_once '../php/funcoes.php';
require_once '../php/menu.php';

$fornecedores = listarFornecedores();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/stylehome.css">
<link rel="stylesheet" href="../css/modal.css" />
<link rel="stylesheet" href="../css/styletabela.css" />

<!-- Ícones -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />

<title>Lista de Fornecedores</title>
</head>
<body>

<div class="container">
    <h1>Lista de Fornecedores</h1>

    <!-- Formulário de busca + filtro -->
    <form action="lista_de_fornecedores.php" method="POST" class="search-form">
        <div class="input-container">
            <input type="text" id="busca" name="busca" placeholder="Insira a Busca (ID ou Razão Social)" />
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
    <table id="tabela-fornecedores">
        <thead>
            <tr>
                <th>ID</th>
                <th>Razão Social</th>
                <th>Responsável</th>
                <th>CNPJ</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fornecedores as $f): ?>
                <td><?= $f['id_fornecedor'] ?></td>
                <td><?= htmlspecialchars($f['razao_social']) ?></td>
                <td><?= htmlspecialchars($f['responsavel']) ?></td>
                <td><?= htmlspecialchars($f['cnpj_fornecedor']) ?></td>
                <td><?= htmlspecialchars($f['email_fornecedor']) ?></td>
                <td class="acoes">
                    <!-- Abrir modal -->
                    <a href="#" onclick="abrirModalFornecedor(<?= $f['id_fornecedor'] ?>)" class="acao" title="Visualizar">
                        <i class="ri-eye-line"></i>
                    </a>
                    <!-- Alterar -->
                    <a href="../alteracoes/Alterar_Fornecedor.php?id=<?= $f['id_fornecedor'] ?>" class="acao" title="Alterar">
                        <i class="ri-edit-line"></i>
                    </a>
                    <!-- deleta-->
                    <a href="#" class="acao btn-dele" onclick="deletarFornecedor(<?= $f['id_fornecedor'] ?>)">
                 <i class="ri-delete-bin-line"></i>
            </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// ====== Modal Visualizar ======
function abrirModalFornecedor(id){
    fetch(`../php/modals/modal_fornecedor.php?id=${id}`)
    .then(res => res.text())
    .then(html => {
        const antigo = document.querySelector('.modal-editar');
        if(antigo) antigo.remove();
        document.body.insertAdjacentHTML('beforeend', html);
    })
    .catch(err => console.error(err));
}

// Fechar modal
document.addEventListener('click', function(e){
    const modal = e.target.closest('.modal-editar');
    if(!modal) return;

    if(!e.target.closest('.modal-editar__container') || e.target.classList.contains('modal-editar__fechar')){
        modal.remove();
    }
});


</script>

</body>
</html>