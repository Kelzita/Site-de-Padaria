<?php 
require_once __DIR__ . '/../funcoes.php';

$id_produto = isset($_GET['id']) ? intval($_GET['id']) : 0;
$produto = null;

if($id_produto > 0){
    $produto = buscarProdutoPorId($id_produto);
}
?>

<?php if($produto): ?>
<div class="modal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">Detalhes do Produto</h2>
            <span class="modal-close">&times;</span>
        </div>

        <div class="modal-body">
            <!-- FOTO CENTRALIZADA -->
            <div class="foto-container full-width">
                <?php if(!empty($produto['imagem_produto'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($produto['imagem_produto']) ?>"  
                         alt="<?= htmlspecialchars($produto['nome_produto']); ?>" 
                         class="foto">
                <?php else: ?>
                    <img src="../img/imagem_padrao.png" alt="Imagem padrão" class="foto">
                <?php endif; ?>
            </div>

            <!-- INFORMAÇÕES -->
            <div class="campo"><label>ID:</label><p><?= htmlspecialchars($produto['id_produto']); ?></p></div>
            <div class="campo"><label>Nome:</label><p><?= htmlspecialchars($produto['nome_produto']); ?></p></div>
            <div class="campo"><label>Descrição:</label><p><?= htmlspecialchars($produto['descricao'] ?? 'Não informado'); ?></p></div>
            <div class="campo"><label>Preço:</label><p>R$ <?= htmlspecialchars($produto['preco']); ?></p></div>
            <div class="campo"><label>Unidade de Medida:</label><p><?= htmlspecialchars($produto['unmedida']); ?></p></div>
            <div class="campo"><label>Validade:</label><p><?= htmlspecialchars($produto['validade']); ?></p></div>
            <div class="campo"><label>Quantidade:</label><p><?= htmlspecialchars($produto['quantidade_produto']); ?></p></div>

            <!-- BOTÃO -->
            <div class="acoes full-width">
                <a href="../alteracoes/Alterar_Produto.php?id=<?= $produto['id_produto']; ?>" class="btn btn-primary">Editar Produto</a>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="../css/modals.css">

<script>
// Delegação de eventos para modais que podem ser criados dinamicamente
document.addEventListener('click', function(event) {
    // Fechar modal ao clicar no fundo
    if(event.target.classList.contains('modal')) {
        event.target.remove();
    }

    // Fechar modal ao clicar no X
    if(event.target.classList.contains('modal-close')) {
        const modal = event.target.closest('.modal');
        if(modal) modal.remove();
    }
});
</script>


<?php else: ?>
<p>Produto não encontrado.</p>
<?php endif; ?>


<!-- ============ CSS ================ -->
<style>
    /* ====== MODAL ====== */
.modal {
  display: block;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.65);
  overflow-y: auto;
  padding: 2rem 0;
  z-index: 1000;
}

.modal-container {
  background: #fff;
  width: 90%;
  max-width: 700px;
  margin: 0 auto;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.15);
  position: relative;
  color: #000;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #eaeaea;
}

.modal-title {
 color: black;
  font-size: 1.5rem;
  font-weight: 700;
}

.modal-close {
  font-size: 1.8rem;
  color: #888;
  cursor: pointer;
}
.modal-close:hover {
  color: #1a1a1a;
}

/* ====== BODY ====== */
.modal-body {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem 1.5rem;
}

.campo {
  margin-bottom: 0.75rem;
}

.full-width {
  grid-column: 1 / -1;
}

label {
  display: block;
  font-weight: 500;
  margin-bottom: 0.3rem;
}

p {
  margin: 0;
  font-size: 0.9rem;
}

/* ====== FOTO ====== */
.foto-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  background: #fafafa;
  border-radius: 10px;
  margin-bottom: 1rem;
}

.foto {
  width: 130px;
  height: 130px;
  object-fit: cover;
  border-radius: 50%;
  border: 3px solid #fff;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  margin-bottom: 0.5rem;
}

/* ====== BOTÕES ====== */
.acoes {
  display: flex;
  justify-content: center; /* centraliza os botões */
  margin-top: 1rem;
  gap: 1rem;
}


.btn {
  padding: 0.6rem 1.2rem;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
}

.btn-primary {
  background: #1a1a1a;
  color: #fff;
}

.btn-primary:hover {
  background: #333;
}

/* ====== RESPONSIVO ====== */
@media (max-width: 768px) {
  .modal-body {
      grid-template-columns: 1fr;
  }
  .foto {
      width: 100px;
      height: 100px;
  }
}
</style>

