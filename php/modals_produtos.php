<<<<<<< Updated upstream

=======
<?php require_once '../php/funcoes.php'; ?>
>>>>>>> Stashed changes
<!-- MODAL DE VISUALIZAR PRODUTO -->
<div id="modalVisualizarProduto" class="modal">
    <div class="modal-content">
        <span id="fecharModal">&times;</span>
        <h3>Detalhes do Produto</h3>
        <div class="modal-body">
            <div class="imagem-preview">
                <img id="modal-imagem" src="#" alt="Imagem do Produto" />
            </div>
            <p><b>ID: </b> <span id="modal-id_produto"></span></p>
            <p><b>Nome: </b> <span id="modal-nome_produto"></span></p>
            <p><b>Descrição: </b> <span id="modal-descricao"></span></p>
            <p><b>Preço: </b> <span id="modal-preco"></span></p>
            <p><b>Unidade de Medida: </b> <span id="modal-unidade_medida"></span></p>
            <p><b>Quantidade: </b> <span id="modal-quantidade_produto"></span></p>
            <p><b>Validade: </b> <span id="modal-validade"></span></p>
            <p><b>Fornecedor: </b> <span id="modal-id_fornecedor"></span></p>
        </div>
        <div class="modal-footer">
            <a id="btnAlterarProduto" href="#" class="btn-alterar">Alterar</a>
        </div>
    </div>
</div>

<!-- MODAL ALTERAR PRODUTO -->
<div id="modalEditarProduto" class="modalEditar" style="display: none;">
    <div class="container">
        <span id="fecharModal">&times;</span>
        <h2>Alterar Produto</h2>
        <form id="form-alterar-produto" action="../php/alterar_produto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_produto" id="alterar-id_produto">

            <label>Foto do Produto:</label>
            <div class="foto-container">
                <img id="alterar-foto-preview-produto" src="../img/produtos/default_produto.png" alt="Preview da Foto do Produto">
    
                <input type="file" name="foto_produto" id="alterar-foto_produto" accept="image/*">
    
                <label for="alterar-foto_produto">
                    <i class="ri-camera-line"></i> Clique para alterar
                </label>
    
                <div class="foto-instructions">Formatos: JPG, PNG • Máx: 2MB</div>
    
                <input type="hidden" name="foto_atual" id="foto_atual_produto">
            </div>

            <label>Nome:</label>
            <input type="text" name="nome_produto" id="alterar-nome_produto" required>

            <label>Descrição:</label>
            <textarea name="descricao" id="alterar-descricao"></textarea>

            <label>Preço:</label>
            <input type="number" name="preco" id="alterar-preco" step="0.01" min="0" required>

            <label>Unidade de Medida:</label>
            <input type="text" name="unidade_medida" id="alterar-unidade_medida" required>

            <label>Quantidade:</label>
            <input type="number" name="quantidade_produto" id="alterar-quantidade_produto" min="0" required>

            <label>Validade:</label>
            <input type="date" name="validade" id="alterar-validade" required>

            <label>Fornecedor:</label>
            <select name="id_fornecedor" id="alterar-fornecedor" required>
                <option value="">Selecione o fornecedor</option>
                <?php foreach ($fornecedores as $fornecedor): ?>
                    <option value="<?= htmlspecialchars($fornecedor['id_fornecedor']); ?>">
                        <?= htmlspecialchars($fornecedor['razao_social']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn-salvar">Salvar Alterações</button>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const modalVisualizar = document.getElementById("modalVisualizarProduto");
    const modalEditar = document.getElementById("modalEditarProduto");

    const fecharVisualizar = modalVisualizar.querySelector(".fechar");
    const fecharEditar = document.getElementById("fecharModalEditar");
    const btnAlterarProduto = document.getElementById("btnAlterarProduto");

    // Função para abrir modal de visualização
    window.visualizarProduto = (produto) => {
        modalVisualizar.style.display = "flex";

        document.getElementById("modal-id_produto").textContent = produto.id_produto;
        document.getElementById("modal-nome_produto").textContent = produto.nome_produto;
        document.getElementById("modal-descricao").textContent = produto.descricao || '';
        document.getElementById("modal-preco").textContent = produto.preco;
        document.getElementById("modal-unidade_medida").textContent = produto.unidade_medida;
        document.getElementById("modal-quantidade_produto").textContent = produto.quantidade_produto;
        document.getElementById("modal-validade").textContent = produto.validade;
        document.getElementById("modal-id_fornecedor").textContent = produto.id_fornecedor || '';

        const img = document.getElementById("modal-imagem");
        if (produto.foto_produto) {
            img.src = produto.foto_produto;
            img.style.display = "block";
        } else {
            img.style.display = "none";
        }

        btnAlterarProduto.onclick = () => {
            modalVisualizar.style.display = "none";
            abrirModalEditar(produto);
        };
    };

    fecharVisualizar.onclick = () => modalVisualizar.style.display = "none";
    fecharEditar.onclick = () => modalEditar.style.display = "none";
    window.onclick = (e) => {
        if (e.target === modalVisualizar) modalVisualizar.style.display = "none";
        if (e.target === modalEditar) modalEditar.style.display = "none";
    };

    function abrirModalEditar(produto) {
        modalEditar.style.display = "flex";

        document.getElementById("editar-id_produto").value = produto.id_produto;
        document.getElementById("editar-nome_produto").value = produto.nome_produto;
        document.getElementById("editar-descricao").value = produto.descricao || '';
        document.getElementById("editar-preco").value = produto.preco;
        document.getElementById("editar-unidade_medida").value = produto.unidade_medida;
        document.getElementById("editar-quantidade_produto").value = produto.quantidade_produto;
        document.getElementById("editar-validade").value = produto.validade;
        document.getElementById("editar-id_fornecedor").value = produto.id_fornecedor || '';

        const preview = document.getElementById("previewFotoEditar");
        if (produto.foto_produto) {
            preview.src = produto.foto_produto;
            preview.style.display = "block";
        } else {
            preview.style.display = "none";
        }
    }

    const fotoInput = document.getElementById("editar-foto_produto");
    fotoInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if(file) {
            document.getElementById("previewFotoEditar").src = URL.createObjectURL(file);
        }
    });
});
</script>
