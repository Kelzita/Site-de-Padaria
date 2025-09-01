<?php 
include '../php/buscar_produto.php'; // Este arquivo deve preencher $produtos e $fornecedores
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/styletabela.css" />
    <title>Lista de Produto</title>

    <style>
        /* Estilos básicos para o modal corrigidos - layout vertical e reto */
        #modalEditar {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            overflow: auto;
        }
        #modalEditar .container {
            background: #fff;
            width: 480px;
            margin: 60px auto;
            padding: 30px 40px;
            border-radius: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            position: relative;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        #modalEditar h2 {
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: 700;
            color: #333;
            font-size: 24px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        #modalEditar #fecharModal {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            color: #333;
        }
        #modalEditar form label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            color: #444;
        }
        #modalEditar form input[type="text"],
        #modalEditar form input[type="number"],
        #modalEditar form input[type="date"],
        #modalEditar form textarea,
        #modalEditar form select,
        #modalEditar form input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            font-size: 15px;
            font-weight: 400;
            color: #333;
            box-sizing: border-box;
            border-radius: 0;
            transition: border-color 0.3s ease;
            display: block;
        }
        #modalEditar form input[type="text"]:focus,
        #modalEditar form input[type="number"]:focus,
        #modalEditar form input[type="date"]:focus,
        #modalEditar form textarea:focus,
        #modalEditar form select:focus,
        #modalEditar form input[type="file"]:focus {
            outline: none;
            border-color: #f26322;
        }
        #modalEditar form textarea {
            resize: vertical;
            min-height: 80px;
        }
        #modalEditar form button.btn-salvar {
            width: 100%;
            background-color: #f26322;
            color: white;
            padding: 12px 0;
            border: none;
            font-weight: 700;
            font-size: 18px;
            cursor: pointer;
            border-radius: 0;
            transition: background-color 0.3s ease;
        }
        #modalEditar form button.btn-salvar:hover {
            background-color: #d1520f;
        }
    </style>
</head>
<body>
<header>
    <img src="../img/logo.png" alt="logo" />
</header>

<div class="container">
    <h1>Lista de Produtos</h1>
    <h2>Buscar Produtos</h2>
    <form action="lista_de_produto.php" method="POST" class="search-form">
        <div class="input-container">
            <input type="text" id="busca" name="busca" placeholder="Insira a Busca por ID ou nome" />
            <button type="submit"><i class="ri-search-line"></i></button>
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
                    <a href="#">Visualizar</a>
                    <a href="#" onclick="return confirmarDelete(<?= $produto['id_produto']; ?>, this)">Deletar</a>
                    <a href="#" onclick='abrirModalEditar(<?= json_encode($produto, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>); return false;'>Alterar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table> 
    <?php else: ?>
        <p style="color:white;">Nenhum produto cadastrado.</p>
    <?php endif; ?>
</div>

<!-- Modal para Alterar Produto -->
<div id="modalEditar">
    <div class="container">
        <span id="fecharModal">&times;</span>
        <h2>Alterar Produto</h2>
        <form id="formEditarProduto" enctype="multipart/form-data">
            <input type="hidden" name="id_produto" id="id_produto" />

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
                <?php foreach ($fornecedores as $forn) : ?>
                    <option value="<?= htmlspecialchars($forn['id_fornecedor']); ?>"><?= htmlspecialchars($forn['nome_fornecedor']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="foto_produto">Foto do Produto:</label>
            <input type="file" id="foto_produto" name="foto_produto" accept="image/*" />

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
        document.getElementById('fornecedor').value = produto.fornecedor_id || '';
    }

    // Fechar modal
    document.getElementById('fecharModal').onclick = function() {
        document.getElementById('modalEditar').style.display = 'none';
    }

    // Fechar modal ao clicar fora
    window.onclick = function(event) {
        if (event.target == document.getElementById('modalEditar')) {
            document.getElementById('modalEditar').style.display = 'none';
        }
    }

    // Enviar formulário para alterar produto
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
                alert('Erro: ' + data.message);
            }
        } catch (error) {
            alert('Erro na conexão com o servidor.');
            console.error(error);
        }
    });

    // Função para deletar produto com confirmação (mantida do seu código)
    async function confirmarDelete(id, element) {
        event.preventDefault();

        if (!confirm('Tem certeza que deseja deletar este produto?')) {
            return false;
        }

        try {
            const response = await fetch('deletar_produto.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id: id})
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                // Remove linha da tabela
                const tr = element.closest('tr');
                if (tr) tr.remove();
            } else {
                alert('Erro: ' + data.message);
            }
        } catch (error) {
            alert('Erro ao conectar com o servidor.');
            console.error(error);
        }

        return false;
    }
</script>

</body>
</html>
