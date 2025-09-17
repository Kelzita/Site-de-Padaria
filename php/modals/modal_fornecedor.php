<?php 
require_once __DIR__ . '/../funcoes.php';

$id_fornecedor = isset($_GET['id']) ? intval($_GET['id']) : 0;
$fornecedor = buscarFornecedorPorId($id_fornecedor);
?>

<?php if($fornecedor): ?>
<div class="modal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">Detalhes do Fornecedor</h2>
            <span class="modal-close">&times;</span>
        </div>

        <div class="modal-body">
            <!-- INFORMAÇÕES EM DUAS COLUNAS -->
            <div class="campo">
                <label>ID:</label>
                <p><?= htmlspecialchars($fornecedor['id_fornecedor']); ?></p>
            </div>
            <div class="campo">
                <label>Razão Social:</label>
                <p><?= htmlspecialchars($fornecedor['razao_social']); ?></p>
            </div>
            <div class="campo">
                <label>Responsável:</label>
                <p><?= htmlspecialchars($fornecedor['responsavel']); ?></p>
            </div>
            <div class="campo">
                <label>CNPJ:</label>
                <p><?= htmlspecialchars($fornecedor['cnpj_fornecedor']); ?></p>
            </div>
            <div class="campo">
                <label>Email:</label>
                <p><?= htmlspecialchars($fornecedor['email_fornecedor']); ?></p>
            </div>
            <div class="campo">
                <label>Telefone:</label>
                <p><?= htmlspecialchars($fornecedor['telefone_fornecedor']); ?></p>
            </div>
            <div class="campo">
                <label>CEP:</label>
                <p><?= htmlspecialchars($fornecedor['cep_fornecedor']); ?></p>
            </div>
            <div class="campo">
                <label>Rua:</label>
                <p><?= htmlspecialchars($fornecedor['rua_fornecedor']); ?></p>
            </div>
            <div class="campo">
                <label>Número:</label>
                <p><?= htmlspecialchars($fornecedor['numero_fornecedor']); ?></p>
            </div>
            <div class="campo">
                <label>Bairro:</label>
                <p><?= htmlspecialchars($fornecedor['bairro_fornecedor']); ?></p>
            </div>
            <div class="campo">
                <label>Cidade:</label>
                <p><?= htmlspecialchars($fornecedor['cidade_fornecedor']); ?></p>
            </div>
            <div class="campo">
                <label>UF:</label>
                <p><?= htmlspecialchars($fornecedor['uf_fornecedor']); ?></p>
            </div>

            <!-- BOTÃO -->
            <div class="acoes full-width">
                <a href="../alteracoes/Alterar_Fornecedor.php?id=<?= $fornecedor['id_fornecedor']; ?>"
                   class="btn btn-primary">Editar Fornecedor</a>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="modals.css"/>

<script>
document.addEventListener('click', function(e){
    const modal = e.target.closest('.modal');
    if(!modal) return;
    if(!e.target.closest('.modal-container') || e.target.classList.contains('modal-close')){
        modal.remove();
    }
});
</script>

<?php else: ?>
<p>Fornecedor não encontrado.</p>
<?php endif; ?>


