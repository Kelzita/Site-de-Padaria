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
  color: #666;
  cursor: pointer;
  transition: transform 0.2s, color 0.2s;
}
.modal-close:hover {
  transform: rotate(90deg);
  color: #111;
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


