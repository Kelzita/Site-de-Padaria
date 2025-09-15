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


