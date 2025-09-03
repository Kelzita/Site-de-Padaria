<?php 
include '../php/buscar_produto.php'; // Preenche $produtos
include '../php/modals_produtos.php'; // Modals
include '../php/excluir_produto.php';
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
    <a href="../alteracoes/Alterar_Produto.php?id=<?= $produto['id_produto'] ?>"" class="btn-alterar" data-produto='<?= htmlspecialchars(json_encode($produto), ENT_QUOTES, 'UTF-8'); ?>' title="Alterar">
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



<script>
document.addEventListener("DOMContentLoaded", () => {
    const modalVisualizar = document.getElementById("modalVisualizarProduto");
    const modalEditar = document.getElementById("modalEditarProduto");

    const fecharVisualizar = modalVisualizar.querySelector(".fechar");
    const fecharEditar = document.getElementById("fecharModalEditar");

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
        document.getElementById("modal-id_fornecedor").textContent = produto.fornecedor_nome || '';

        const img = document.getElementById("modal-imagem");
        if (produto.foto_produto) {
            img.src = produto.foto_produto;
            img.style.display = "block";
        } else {
            img.style.display = "none";
        }

        // Botão dentro do modal visualizar para abrir o modal editar
        const btnAlterarProduto = document.getElementById("btnAlterarProduto");
        if(btnAlterarProduto){
            btnAlterarProduto.onclick = () => {
                modalVisualizar.style.display = "none";
                abrirModalEditar(produto);
            };
        }
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

    // Corrigindo os botões de "Alterar" na tabela
    document.querySelectorAll('.btn-alterar').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault(); // evita que o link navegue
            const produto = JSON.parse(btn.getAttribute('data-produto'));
            abrirModalEditar(produto);
        });
    });
});
</script>
<script>
function confirmarExcluirProduto(idProduto, elemento) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        fetch('../php/excluir_produto.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_produto=${idProduto}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove a linha da tabela
                const row = elemento.closest('tr');
                row.parentNode.removeChild(row);
            } else {
                alert('Erro ao excluir: ' + (data.error || 'erro desconhecido'));
            }
        })
        .catch(err => {
            alert('Erro na requisição: ' + err);
        });
    }
}
</script>

