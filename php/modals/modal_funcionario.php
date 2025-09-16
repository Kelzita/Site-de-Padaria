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
<link rel="stylesheet" href="modals.css"/>
<?php else: ?>
<p>Funcionário não encontrado.</p>
<?php endif; ?>


