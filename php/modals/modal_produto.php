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
            <div class="campo"><label>Fornecedor:</label><p><?= htmlspecialchars($produto['razao_social']); ?></p></div>

            <!-- BOTÃO -->
            <div class="acoes full-width">
                <a href="../alteracoes/Alterar_Produto.php?id=<?= $produto['id_produto']; ?>" class="btn btn-primary">Editar Produto</a>
            </div>
        </div>
    </div>
</div>



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


<!-- ========== CSS =========== -->
<style>
  /* ====== MODAL ====== */
.modal {
  display: block;
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  overflow-y: auto;
  padding: 2rem 0;
  z-index: 1000;
  animation: fadeIn 0.3s ease-in-out;
}

.modal-container {
  background: #ffffff;
  width: 90%;
  max-width: 750px;
  margin: 0 auto;
  padding: 2rem;
  border-radius: 14px;
  box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
  position: relative;
  color: #2b2b2b;
  animation: slideUp 0.3s ease;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ====== HEADER ====== */
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.8rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #e0e0e0;
}

.modal-title {
  font-size: 1.6rem;
  font-weight: 700;
  color: #1c1c24;
}

.modal-close {
    font-size: 1.8rem;
    color: #888;
    cursor: pointer;
    line-height: 1;       
    display: inline-block;

}

.modal-close:hover {
    color: #1a1a1a;
}


/* ====== BODY ====== */
.modal-body {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.2rem 1.8rem;
}

.campo {
  display: flex;
  flex-direction: column;
  background: #fafafa;
  padding: 0.8rem 1rem;
  border-radius: 8px;
  border: 1px solid #eaeaea;
  transition: background 0.2s, border 0.2s;
}
.campo:hover {
  background: #f5f5f5;
  border-color: #d4d4d4;
}

.full-width {
  grid-column: 1 / -1;
}

label {
  font-weight: 700;
  font-size: 0.9rem;
  color: #444;
  margin-bottom: 0.3rem;
  
}

p {
  margin: 0;
  font-size: 0.95rem;
  color: #222;
  font-weight: 400; /* garante texto normal */
}


/* ====== FOTO ====== */
.foto-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  background: linear-gradient(135deg, #f9f9f9, #f0f0f0);
  border-radius: 12px;
  border: 1px solid #e5e5e5;
  margin-bottom: 1rem;
}

.foto {
  width: 140px;
  height: 140px;
  object-fit: cover;
  border-radius: 50%;
  border: 4px solid #fff;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
  margin-bottom: 0.5rem;
}

/* ====== BOTÕES ====== */
.acoes {
  display: flex;
  justify-content: center;
  margin-top: 1.2rem;
  gap: 1rem;
}

.btn {
  padding: 0.65rem 1.4rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.95rem;
  text-decoration: none;
  cursor: pointer;
  transition: background 0.2s, transform 0.2s;
}

.btn-primary {
  background: #1c1c24;
  color: #fff;
}
.btn-primary:hover {
  background: #333;
  transform: translateY(-2px);
}

/* ====== ANIMAÇÕES ====== */
@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}
@keyframes slideUp {
  from {transform: translateY(30px); opacity: 0;}
  to {transform: translateY(0); opacity: 1;}
}

/* ====== RESPONSIVO ====== */
@media (max-width: 768px) {
  .modal-body {
      grid-template-columns: 1fr;
  }
  .foto {
      width: 110px;
      height: 110px;
  }
}
</style>