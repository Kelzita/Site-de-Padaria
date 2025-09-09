<?php 
require_once '../php/buscar_funcionario.php'; 
require_once '../php/menu.php';
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
    
    <title>Lista de Funcionários</title>
    <link rel="icon" href="img/logo_title.png">
</head>
<style>
    .voltar {
  width: 50px ;
  height: 40px ;
  margin-top: 20px;
  margin-left: -1250px;
  left: 5px;
}

.seta1 {
  width: 50px ;
  height: 40px ;
  margin-top: 20px;
  margin-left: 20px;
  left: 5px;
}

</style>
<body>

<div class="container">
    <h1>Lista de Funcionários</h1>

    <!-- Formulário de busca + filtro -->
    <form action="lista_de_funcionarios.php" method="POST" class="search-form">
        <div class="input-container">
            <input type="text" id="busca" name="busca" placeholder="Insira a Busca (ID ou nome)" />
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
    <div class="select">
    <select id="filtro-status" name="status">
                <option value="">Todos</option>
                <option value="1">Ativos</option>
                <option value="0">Inativos</option>
            </select>
    </div>

    <table id="tabela-funcionarios">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funcionarios as $funcionario): ?>
            <tr data-status="<?= $funcionario['ativo'] ?>">
                <td><?= $funcionario['id_funcionario'] ?></td>
                <td><?= htmlspecialchars($funcionario['nome_funcionario']) ?></td>
                <td><?= htmlspecialchars($funcionario['email_funcionario']) ?></td>
                <td><?= htmlspecialchars($funcionario['telefone_funcionario']) ?></td>
                <td class="status">
                    <?= $funcionario['ativo'] ? 'Ativo' : 'Inativo' ?>
                </td>
                <td class="acoes">
                    <a href="#" onclick="abrirModalFuncionario(<?= $funcionario['id_funcionario'] ?>)" class="acao" title="Visualizar">
                        <i class="ri-eye-line"></i>
                    </a>
                    <a href="../alteracoes/Alterar_Funcionario.php?id=<?= $funcionario['id_funcionario'] ?>" class="acao" title="Alterar">
                        <i class="ri-edit-line"></i>
                    </a>
                    <a href="#" class="acao btn-inativar" onclick="toggleAtivo(this, <?= $funcionario['id_funcionario'] ?>)">
                        <i class="<?= $funcionario['ativo'] ? 'ri-user-unfollow-line' : 'ri-user-follow-line' ?>"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<a href="../inicio/home.php" class="voltar"> 
        <img class="seta" src="../img/btn_voltar.png" title="seta">
</a>

<script>
// ====== Modal Visualizar ======
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

    if(!e.target.closest('.modal-editar__container') || e.target.classList.contains('modal-editar__fechar')){
        modal.remove();
    }
});

// ====== Toggle Ativo/Inativo ======
function toggleAtivo(element, id) {
    if (!confirm('Deseja alterar o status deste funcionário?')) return;

    fetch('../php/inativar_funcionario.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id_funcionario=${id}`
    }).then(res => res.json())
    .then(data => {
        if(data.sucesso) {
            const tr = element.closest('tr');
            const statusCell = tr.querySelector('.status');
            const icone = element.querySelector('i');

            if (data.ativo) {
                statusCell.textContent = 'Ativo';
                icone.classList.remove('ri-user-follow-line');
                icone.classList.add('ri-user-unfollow-line');
                tr.setAttribute('data-status', 1);
            } else {
                statusCell.textContent = 'Inativo';
                icone.classList.remove('ri-user-unfollow-line');
                icone.classList.add('ri-user-follow-line');
                tr.setAttribute('data-status', 0);
            }
        } else {
            alert('Erro ao alterar status!');
        }
    }).catch(err => console.error(err));
}

// ====== Filtro Ativos/Inativos via select ======
document.getElementById('filtro-status').addEventListener('change', function(){
    const status = this.value;
    document.querySelectorAll('#tabela-funcionarios tbody tr').forEach(tr => {
        if(status === '') {
            tr.style.display = '';
        } else {
            tr.style.display = tr.dataset.status === status ? '' : 'none';
        }
    });
});
</script>
</body>
</html>
