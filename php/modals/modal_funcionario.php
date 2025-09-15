<?php 
require_once __DIR__ . '/../funcoes.php';

$id_funcionario = isset($_GET['id']) ? intval($_GET['id']) : 0;
$funcionario = null;

if($id_funcionario > 0){
    $funcionario = buscarFuncionarioPorId($id_funcionario);
}
?>

<?php if($funcionario): ?>
<div class="modal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">Detalhes do Funcionário</h2>
            <span class="modal-close">&times;</span>
        </div>

        <div class="modal-body">
            <!-- FOTO CENTRALIZADA -->
            <div class="foto-container full-width">
                <?php if(!empty($funcionario['imagem_funcionario'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($funcionario['imagem_funcionario']) ?>"
                         alt="<?= htmlspecialchars($funcionario['nome_funcionario']); ?>" class="foto">
                <?php else: ?>
                    <img src="../img/imagem_padrao.png" alt="Imagem padrão" class="foto">
                <?php endif; ?>
            </div>

            <!-- ID -->
            <div class="campo full-width">
                <label>ID:</label>
                <p><?= htmlspecialchars($funcionario['id_funcionario']); ?></p>
            </div>

            <!-- INFORMAÇÕES EM DUAS COLUNAS -->
            <div class="campo">
                <label>Função:</label>
                <p><?= htmlspecialchars($funcionario['nome_funcao']); ?></p>
            </div>
            <div class="campo">
                <label>Nome:</label>
                <p><?= htmlspecialchars($funcionario['nome_funcionario']); ?></p>
            </div>
            <div class="campo">
                <label>CPF:</label>
                <p><?= htmlspecialchars($funcionario['cpf_funcionario']); ?></p>
            </div>
            <div class="campo">
                <label>Email:</label>
                <p><?= htmlspecialchars($funcionario['email_funcionario']); ?></p>
            </div>
            <div class="campo">
                <label>CEP:</label>
                <p><?= htmlspecialchars($funcionario['cep_funcionario']); ?></p>
            </div>
            <div class="campo">
                <label>Rua:</label>
                <p><?= htmlspecialchars($funcionario['rua_funcionario']); ?></p>
            </div>
            <div class="campo">
                <label>Número:</label>
                <p><?= htmlspecialchars($funcionario['numero_funcionario']); ?></p>
            </div>
            <div class="campo">
                <label>Bairro:</label>
                <p><?= htmlspecialchars($funcionario['bairro_funcionario']); ?></p>
            </div>
            <div class="campo">
                <label>Cidade:</label>
                <p><?= htmlspecialchars($funcionario['cidade_funcionario']); ?></p>
            </div>
            <div class="campo">
                <label>UF:</label>
                <p><?= htmlspecialchars($funcionario['uf_funcionario']); ?></p>
            </div>
            <div class="campo">
                <label>Telefone:</label>
                <p><?= htmlspecialchars($funcionario['telefone_funcionario']); ?></p>
            </div>
            <div class="campo">
                <label>Data de Admissão:</label>
                <p><?= htmlspecialchars($funcionario['data_admissao']); ?></p>
            </div>
            <div class="campo">
                <label>Salário:</label>
                <p>R$ <?= htmlspecialchars($funcionario['salario']); ?></p>
            </div>
            <div class="campo">
                <label>Senha:</label>
                <p><?= htmlspecialchars(substr($funcionario['senha'], 0, 10)); ?></p>
            </div>
            <div class="campo">
                <label>Ativo:</label>
                <p><?= $funcionario['ativo'] ? 'Sim' : 'Não'; ?></p>
            </div>

            <!-- BOTÃO -->
            <div class="acoes full-width">
                <a href="../alteracoes/Alterar_Funcionario.php?id=<?= $funcionario['id_funcionario']; ?>"
                   class="btn btn-primary">Editar Funcionário</a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<p>Funcionário não encontrado.</p>
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

