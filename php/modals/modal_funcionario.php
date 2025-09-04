<?php 
require_once __DIR__ . '/../funcoes.php';

$id_funcionario = isset($_GET['id']) ? intval($_GET['id']) : 0;
$funcionario = null;

if($id_funcionario > 0){
    $funcionario = buscarFuncionarioPorId($id_funcionario);
}
?>

<?php if($funcionario): ?>
<div class="modal-editar">
    <div class="modal-editar__container" style="background:#fff; color:#000;">
        <div class="modal-editar__header">
            <h2 class="modal-editar__titulo">Detalhes do Funcionário</h2>
            <span class="modal-editar__fechar">&times;</span>
        </div>

        <div class="formulario">
            <div class="container-foto">
                <?php if(!empty($funcionario['imagem_funcionario'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($funcionario['imagem_funcionario']) ?>"  
                         alt="<?= htmlspecialchars($funcionario['nome_funcionario']); ?>" 
                         class="previsualizacao-foto">
                <?php else: ?>
                    <img src="../img/imagem_padrao.png" alt="Imagem padrão" class="previsualizacao-foto">
                <?php endif; ?>
            </div>

        
            <div class="grupo-formulario">
                <label><b>ID:</b></label>
    <p><?= htmlspecialchars($funcionario['id_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Função:</b></label>
    <p><?= htmlspecialchars($funcionario['nome_funcao']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Nome:</b></label>
    <p><?= htmlspecialchars($funcionario['nome_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>CPF:</b></label>
    <p><?= htmlspecialchars($funcionario['cpf_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Email:</b></label>
    <p><?= htmlspecialchars($funcionario['email_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>CEP:</b></label>
    <p><?= htmlspecialchars($funcionario['cep_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Rua:</b></label>
    <p><?= htmlspecialchars($funcionario['rua_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Número:</b></label>
    <p><?= htmlspecialchars($funcionario['numero_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Bairro:</b></label>
    <p><?= htmlspecialchars($funcionario['bairro_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Cidade:</b></label>
    <p><?= htmlspecialchars($funcionario['cidade_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>UF:</b></label>
    <p><?= htmlspecialchars($funcionario['uf_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Telefone:</b></label>
    <p><?= htmlspecialchars($funcionario['telefone_funcionario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Data de Admissão:</b></label>
    <p><?= htmlspecialchars($funcionario['data_admissao']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Salário:</b></label>
    <p>R$ <?= htmlspecialchars($funcionario['salario']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Senha:</b></label>
    <p><?= htmlspecialchars(substr($funcionario['senha'], 0, 10)); ?></p>
</div>
<div class="grupo-formulario"><label><b>Senha Temporária:</b></label>
    <p><?= htmlspecialchars($funcionario['senha_temporaria']); ?></p>
</div>
<div class="grupo-formulario"><label><b>Ativo:</b></label>
    <p><?= $funcionario['ativo'] ? 'Sim' : 'Não'; ?></p>
</div>


            <div class="acoes-formulario">
                <a href="../alteracoes/Alterar_Funcionario.php?id=<?= $funcionario['id_funcionario']; ?>" 
                   class="botao botao--primario">Editar Funcionário</a>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="../css/modals.css">

<?php else: ?>
<p>Funcionário não encontrado.</p>
<?php endif; ?>
