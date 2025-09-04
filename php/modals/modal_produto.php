<?php 
require_once __DIR__ . '/../funcoes.php';

$id_produto = isset($_GET['id']) ? intval($_GET['id']) : 0;
$produto = null;

if($id_produto > 0){
    $produto = buscarProdutoPorId($id_produto);
}
?>

<?php if($produto): ?>
<div class="modal-editar">
    <div class="modal-editar__container">
        <div class="modal-editar__header">
            <h2 class="modal-editar__titulo">Detalhes do Produto</h2>
            <span class="modal-editar__fechar">&times;</span>
        </div>

        <div class="formulario">
            <div class="container-foto">
                <?php if(!empty($produto['imagem_produto'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($produto['imagem_produto']) ?>"  
                         alt="<?= htmlspecialchars($produto['nome_produto']); ?>" 
                         class="previsualizacao-foto">
                <?php else: ?>
                    <img src="../img/imagem_padrao.png" alt="Imagem padrão" class="previsualizacao-foto">
                <?php endif; ?>
            </div>

            <div class="grupo-formulario"><label>ID:</label><p><?= htmlspecialchars($produto['id_produto']); ?></p></div>
            <div class="grupo-formulario"><label>Nome:</label><p><?= htmlspecialchars($produto['nome_produto']); ?></p></div>
            <div class="grupo-formulario"><label>Descrição:</label><p><?= htmlspecialchars($produto['descricao'] ?? 'Não informado'); ?></p></div>
            <div class="grupo-formulario"><label>Preço:</label><p>R$ <?= htmlspecialchars($produto['preco']); ?></p></div>
            <div class="grupo-formulario"><label>Unidade de Medida:</label><p><?= htmlspecialchars($produto['unmedida']); ?></p></div>
            <div class="grupo-formulario"><label>Validade:</label><p><?= htmlspecialchars($produto['validade']); ?></p></div>
            <div class="grupo-formulario"><label>Quantidade:</label><p><?= htmlspecialchars($produto['quantidade_produto']); ?></p></div>

            <div class="acoes-formulario">
                <a href="../alteracoes/Alterar_Produto.php?id=<?= $produto['id_produto']; ?>" class="botao botao--primario">Editar Produto</a>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="../css/modals.css">


<script>
// Delegação de eventos para funcionar mesmo com modais dinâmicos
document.addEventListener('click', function(event){
    if(event.target.classList.contains('modal-editar')) {
        event.target.remove();
    }
    if(event.target.classList.contains('modal-editar__fechar')) {
        const modal = event.target.closest('.modal-editar');
        if(modal) modal.remove();
    }
});
</script>

<?php else: ?>
<p>Produto não encontrado.</p>
<?php endif; ?>
