<?php 
include '../php/buscar_produto.php'; // Preenche $produtos
include '../php/modals_produtos.php'; // Modals
require_once '../php/funcoes.php';
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/modal.css" />
    <link rel="stylesheet" href="../css/styletabela.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
    <title>Lista de Produtos</title>
</head>
<body>
<header>
    <img src="../img/logo.png" alt="logo" />
</header>

<div class="container">
    <h1>Lista de Produtos</h1>

    <form action="lista_de_produto.php" method="POST" class="search-form">
        <div class="input-container">
            <input type="text" id="busca" name="busca" placeholder="Insira a Busca (por ID ou nome)" />
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>

    <?php if (!empty($produtos)) : ?>
    <table border="1" bgcolor="white">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nome do Produto</th>
            <th>Validade</th>
            <th>Quantidade</th>  
            <th>Ações</th>  
        </tr>
        </thead>
        <tbody>
        <?php foreach ($produtos as $produto) : ?>
            <tr>
                <td><?= htmlspecialchars($produto['id_produto']); ?></td>
                <td><?= htmlspecialchars($produto['nome_produto']); ?></td>
                <td><?= htmlspecialchars($produto['validade']); ?></td>
                <td><?= htmlspecialchars($produto['quantidade_produto']); ?></td>
                <td>
                    <!-- Botão Visualizar -->
                    <a href="#" onclick='visualizarProduto(<?= json_encode($produto, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT); ?>)' title="Visualizar">
                        <i class="ri-eye-line" style="font-size:1.2rem; color:#007bff;"></i>
                    </a>

                    <!-- Botão Alterar -->
                    <a href="#" class="btn-alterar" data-produto='<?= htmlspecialchars(json_encode($produto), ENT_QUOTES, 'UTF-8'); ?>' title="Alterar">
                        <i class="ri-pencil-line" style="font-size:1.2rem; color:#3D2412;"></i>
                    </a>

                    <!-- Botão Inativar/Desativar -->
                    <a href="#" onclick="return confirmarInativar(<?= $produto['id_produto']; ?>)" title="Inativar">
                        <i class="ri-delete-bin-line" style="font-size:1.2rem; color:#b30000;"></i>
                    </a>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="color:white;">Nenhum produto cadastrado.</p>
    <?php endif; ?>
</div>
</body>
</html>



<!-- Modal para Alterar Produto -->
<div id="modalEditar">
    <div class="container">
        <span id="fecharModal">&times;</span>
        <h2>Alterar Produto</h2>

        <div class="imagem-preview">
            <img id="previewFoto" src="#" alt="Prévia da Foto" />
        </div>

        <form id="formEditarProduto" enctype="multipart/form-data">
            <input type="hidden" name="id_produto" id="id_produto" />

            <label for="foto_produto">Foto do Produto:</label>
            <input type="file" id="foto_produto" name="foto_produto" accept="image/*" />

            <label for="nome_produto">Nome do Produto:</label>
            <input type="text" id="nome_produto" name="nome_produto" placeholder="Insira o nome do produto" required />

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" placeholder="Insira uma descrição (Opcional)"></textarea>

            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="preco" placeholder="R$ 0,00" required />

            <label for="unidade_medida">Unidade de Medida:</label>
            <input type="text" id="unidade_medida" name="unidade_medida" placeholder="Ex: Kg, un, L" required />

            <label for="quantidade_produto">Quantidade do Produto:</label>
            <input type="number" id="quantidade_produto" name="quantidade_produto" placeholder="Digite a quantidade disponível" required />

            <label for="validade">Validade:</label>
            <input type="date" id="validade" name="validade" required />

            <label for="fornecedor">Fornecedor:</label>
            <select id="fornecedor" name="fornecedor" required>
            <option value="">Selecione o fornecedor</option>
                <?php foreach ($fornecedores as $fornecedor): ?>
                    <option value="<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>" 
                    <?= $fornecedor['id_fornecedor'] == $idSelecionadoFornecedor ? 'selected' : '' ?>>
                 <?= htmlspecialchars($fornecedor['id_fornecedor']), ' - ' ,htmlspecialchars($fornecedor['razao_social']) ?>
            </option>
            <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-salvar">Salvar Alteração</button>
        </form>
    </div>
</div>

<script>
    // Função para abrir modal e preencher os campos
    function abrirModalEditar(produto) {
        document.getElementById('modalEditar').style.display = 'block';

        document.getElementById('id_produto').value = produto.id_produto || '';
        document.getElementById('nome_produto').value = produto.nome_produto || '';
        document.getElementById('descricao').value = produto.descricao || '';
        document.getElementById('preco').value = produto.preco || '';
        document.getElementById('unidade_medida').value = produto.unidade_medida || '';
        document.getElementById('quantidade_produto').value = produto.quantidade_produto || '';
        document.getElementById('validade').value = produto.validade || '';

        // Corrija aqui o nome da chave do fornecedor que vem no JSON.
        // Supondo que no objeto produto a chave do fornecedor seja 'id_fornecedor':
        let fornecedorId = produto.id_fornecedor || produto.fornecedor_id || '';

        document.getElementById('fornecedor').value = fornecedorId;

        // Mostrar pré-visualização da imagem (se tiver)
        const preview = document.getElementById('previewFoto');
        if (produto.foto_produto) {
            preview.src = produto.foto_produto; // Ajuste o caminho conforme seu dado
            preview.style.display = 'block';
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }

    // Associa os botões Alterar para abrir modal via data-produto
    document.querySelectorAll('.btn-alterar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const produto = JSON.parse(this.dataset.produto);
            abrirModalEditar(produto);
        });
    });

    // Fechar modal
    document.getElementById('fecharModal').onclick = function() {
        document.getElementById('modalEditar').style.display = 'none';
    }

    // Fechar modal ao clicar fora da área do container
    window.onclick = function(event) {
        const modal = document.getElementById('modalEditar');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    // Enviar formulário para alterar produto via fetch
    document.getElementById('formEditarProduto').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch('alterar_produto.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                location.reload(); // Atualiza a página para refletir as mudanças
            } else {
                alert('Erro: ' + (data.message || 'Não foi possível salvar as alterações.'));
            }
        } catch (error) {
            alert('Erro na requisição: ' + error.message);
        }
    });
</script>
</body>
</html>
