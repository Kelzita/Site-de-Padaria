<?php
require_once '../php/funcoes.php';

// Obter o ID do fornecedor da URL
$id_fornecedor = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Buscar os dados do fornecedor
$fornecedor = null;
if ($id_fornecedor > 0) {
    $fornecedor = buscarFornecedorPorId($id_fornecedor);
}

// Se não encontrar, exibir mensagem de erro simples
if (!$fornecedor) {
    echo '<p>Fornecedor não encontrado.</p>';
    exit;
}
?>

<div class="modal-editar">
    <div class="modal-editar__container">
        <div class="modal-editar__header">
            <h2 class="modal-editar__titulo">Detalhes do Fornecedor</h2>
            <span class="modal-editar__fechar">&times;</span>
        </div>

        <form class="formulario">
            <div class="grupo-formulario grupo-formulario--completo container-foto">
                <?php if (!empty($fornecedor['imagem_fornecedor'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($fornecedor['imagem_fornecedor']) ?>" alt="Foto do fornecedor" class="previsualizacao-foto">
                <?php else: ?>
                    <img src="../img/placeholder.png" alt="Preview" class="previsualizacao-foto">
                <?php endif; ?>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">ID:</label>
                <p><?= htmlspecialchars($fornecedor['id_fornecedor']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Razão Social:</label>
                <p><?= htmlspecialchars($fornecedor['razao_social']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Responsável:</label>
                <p><?= htmlspecialchars($fornecedor['responsavel']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">CNPJ:</label>
                <p><?= htmlspecialchars($fornecedor['cnpj_fornecedor']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">E-mail:</label>
                <p><?= htmlspecialchars($fornecedor['email_fornecedor']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Telefone:</label>
                <p><?= htmlspecialchars($fornecedor['telefone_fornecedor']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">CEP:</label>
                <p><?= htmlspecialchars($fornecedor['cep_fornecedor']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Rua:</label>
                <p><?= htmlspecialchars($fornecedor['rua_fornecedor']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Número:</label>
                <p><?= htmlspecialchars($fornecedor['numero_fornecedor']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Bairro:</label>
                <p><?= htmlspecialchars($fornecedor['bairro_fornecedor']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Cidade:</label>
                <p><?= htmlspecialchars($fornecedor['cidade_fornecedor']); ?></p>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">UF:</label>
                <p><?= htmlspecialchars($fornecedor['uf_fornecedor']); ?></p>
            </div>

            <div class="acoes-formulario">
                <a href="../alteracoes/Alterar_Fornecedor.php?id=<?= $fornecedor['id_fornecedor'] ?>" class="botao botao--primario">Alterar</a>
                <span class="botao botao--secundario modal-editar__fechar">Fechar</span>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="../css/modals.css">