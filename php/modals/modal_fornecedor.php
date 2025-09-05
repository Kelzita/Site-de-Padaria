<?php 
require_once __DIR__ . '/../funcoes.php';

$id_fornecedor = isset($_GET['id']) ? intval($_GET['id']) : 0;
$fornecedor = buscarFornecedorPorId($id_fornecedor);
?>

<?php if($fornecedor): ?>
<div class="modal-editar">
    <div class="modal-editar__container">
        <div class="modal-editar__header">
            <h2 class="modal-editar__titulo">Detalhes do Fornecedor</h2>
            <span class="modal-editar__fechar">&times;</span>
        </div>

        <div class="formulario">
            <div class="grupo-formulario"><label>ID:</label><p><?= htmlspecialchars($fornecedor['id_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Razão Social:</label><p><?= htmlspecialchars($fornecedor['razao_social']); ?></p></div>
            <div class="grupo-formulario"><label>Responsável:</label><p><?= htmlspecialchars($fornecedor['responsavel']); ?></p></div>
            <div class="grupo-formulario"><label>CNPJ:</label><p><?= htmlspecialchars($fornecedor['cnpj_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Email:</label><p><?= htmlspecialchars($fornecedor['email_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Telefone:</label><p><?= htmlspecialchars($fornecedor['telefone_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>CEP:</label><p><?= htmlspecialchars($fornecedor['cep_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Rua:</label><p><?= htmlspecialchars($fornecedor['rua_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Número:</label><p><?= htmlspecialchars($fornecedor['numero_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Bairro:</label><p><?= htmlspecialchars($fornecedor['bairro_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Cidade:</label><p><?= htmlspecialchars($fornecedor['cidade_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>UF:</label><p><?= htmlspecialchars($fornecedor['uf_fornecedor']); ?></p></div>

            <div class="acoes-formulario">
                <a href="../alteracoes/Alterar_Fornecedor.php?id=<?= $fornecedor['id_fornecedor']; ?>" class="botao botao--primario">Editar Fornecedor</a>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="../css/modals.css">

<script>
document.addEventListener('click', function(e){
    if(e.target.classList.contains('modal-editar') || e.target.classList.contains('modal-editar__fechar')){
        const modal = e.target.closest('.modal-editar');
        if(modal) modal.remove();
    }
});
</script>

<?php else: ?>
<p>Fornecedor não encontrado.</p>
<?php endif; ?>
<?php 
require_once __DIR__ . '/../funcoes.php';

$id_fornecedor = isset($_GET['id']) ? intval($_GET['id']) : 0;
$fornecedor = buscarFornecedorPorId($id_fornecedor);
?>

<?php if($fornecedor): ?>
<div class="modal-editar">
    <div class="modal-editar__container">
        <div class="modal-editar__header">
            <h2 class="modal-editar__titulo">Detalhes do Fornecedor</h2>
            <span class="modal-editar__fechar">&times;</span>
        </div>

        <div class="formulario">
            <div class="grupo-formulario"><label>ID:</label><p><?= htmlspecialchars($fornecedor['id_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Razão Social:</label><p><?= htmlspecialchars($fornecedor['razao_social']); ?></p></div>
            <div class="grupo-formulario"><label>Responsável:</label><p><?= htmlspecialchars($fornecedor['responsavel']); ?></p></div>
            <div class="grupo-formulario"><label>CNPJ:</label><p><?= htmlspecialchars($fornecedor['cnpj_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Email:</label><p><?= htmlspecialchars($fornecedor['email_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Telefone:</label><p><?= htmlspecialchars($fornecedor['telefone_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>CEP:</label><p><?= htmlspecialchars($fornecedor['cep_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Rua:</label><p><?= htmlspecialchars($fornecedor['rua_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Número:</label><p><?= htmlspecialchars($fornecedor['numero_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Bairro:</label><p><?= htmlspecialchars($fornecedor['bairro_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>Cidade:</label><p><?= htmlspecialchars($fornecedor['cidade_fornecedor']); ?></p></div>
            <div class="grupo-formulario"><label>UF:</label><p><?= htmlspecialchars($fornecedor['uf_fornecedor']); ?></p></div>

            <div class="acoes-formulario">
                <a href="../alteracoes/Alterar_Fornecedor.php?id=<?= $fornecedor['id_fornecedor']; ?>" class="botao botao--primario">Editar Fornecedor</a>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="../css/modals.css">

<script>
document.addEventListener('click', function(e){
    if(e.target.classList.contains('modal-editar') || e.target.classList.contains('modal-editar__fechar')){
        const modal = e.target.closest('.modal-editar');
        if(modal) modal.remove();
    }
});
</script>

<?php else: ?>
<p>Fornecedor não encontrado.</p>
<?php endif; ?>