<?php 
require_once __DIR__ . '/../funcoes.php';

$id_fornecedor = isset($_GET['id']) ? intval($_GET['id']) : 0;
$fornecedor = null;

if($id_fornecedor > 0){
    $fornecedor = buscarFornecedorPorId($id_fornecedor);
}
?>

<?php if($fornecedor): ?>
<div class="modal-editar">
    <div class="modal-editar__container" style="background:#fff; color:#000;">
        <div class="modal-editar__header">
            <h2 class="modal-editar__titulo">Detalhes do Fornecedor</h2>
            <span class="modal-editar__fechar">&times;</span>
        </div>

        <div class="formulario">
            <div class="container-foto">
                <?php if(!empty($fornecedor['foto_fornecedor'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($fornecedor['foto_fornecedor']) ?>"  
                         alt="<?= htmlspecialchars($fornecedor['razao_social']); ?>" 
                         class="previsualizacao-foto">
                <?php else: ?>
                    <img src="../img/imagem_padrao.png" alt="Imagem padrão" class="previsualizacao-foto">
                <?php endif; ?>
            </div>

            <div class="grupo-formulario"><label><b>ID:</b></label>
                <p><?= htmlspecialchars($fornecedor['id_fornecedor']); ?></p>
            </div>
            <div class="grupo-formulario"><label><b>Razão Social:</b></label>
                <p><?= htmlspecialchars($fornecedor['razao_social']); ?></p>
            </div>

            <div class="grupo-formulario"><label><b>Responsável:</b></label>
                <p><?= htmlspecialchars($fornecedor['responsavel']); ?></p>
            </div>
            <div class="grupo-formulario"><label><b>CNPJ:</b></label>
                <p><?= htmlspecialchars($fornecedor['cnpj_fornecedor']); ?></p>
            </div>
            <div class="grupo-formulario"><label><b>Email:</b></label>
                <p><?= htmlspecialchars($fornecedor['email_fornecedor']); ?></p>
            </div>
            <div class="grupo-formulario"><label><b>Telefone:</b></label>
                <p><?= htmlspecialchars($fornecedor['telefone_fornecedor']); ?></p>
            </div>
            <div class="grupo-formulario"><label><b>CEP:</b></label>
                <p><?= htmlspecialchars($fornecedor['cep_fornecedor']); ?></p>
            </div>
            <div class="grupo-formulario"><label><b>Rua:</b></label>
                <p><?= htmlspecialchars($fornecedor['rua_fornecedor']); ?></p>
            </div>
            <div class="grupo-formulario"><label><b>Número:</b></label>
                <p><?= htmlspecialchars($fornecedor['numero_fornecedor']); ?></p>
            </div>
            <div class="grupo-formulario"><label><b>Bairro:</b></label>
                <p><?= htmlspecialchars($fornecedor['bairro_fornecedor']); ?></p>
            </div>
            <div class="grupo-formulario"><label><b>Cidade:</b></label>
                <p><?= htmlspecialchars($fornecedor['cidade_fornecedor']); ?></p>
            </div>
            <div class="grupo-formulario"><label><b>UF:</b></label>
                <p><?= htmlspecialchars($fornecedor['uf_fornecedor']); ?></p>
            </div>
            

            <div class="acoes-formulario">
                <a href="../alteracoes/Alterar_Fornecedor.php?id=<?= $fornecedor['id_fornecedor']; ?>" 
                   class="botao botao--primario">Editar Fornecedor</a>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="../css/modals.css">

<?php else: ?>
<p>Fornecedor não encontrado.</p>
<?php endif; ?>
