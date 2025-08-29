<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Produtos</title>
    
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
        }

        /* Modal básico */
        #modal-edicao {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        #modal-edicao > div {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 350px;
            position: relative;
        }
        #modal-edicao span.close-modal {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }
        form label {
            display: block;
            margin-top: 10px;
        }
        form input, form select {
            width: 100%;
            padding: 5px;
            margin-top: 4px;
            box-sizing: border-box;
        }
        form button {
            margin-top: 15px;
            width: 100%;
            background: #007BFF;
            color: white;
            border: none;
            font-size: 16px;
        }
        form button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<h1>Lista de Produtos</h1>

<table id="tabela-produtos">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Unidade</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <!-- Exemplo de um produto -->
        <tr data-indice="0">
            <td>1</td>
            <td>Produto 1</td>
            <td>10.00</td>
            <td>kg</td>
            <td>50</td>
            <td><button type="button" onclick="abrirModal(0)">Alterar</button></td>
        </tr>
        <tr data-indice="1">
            <td>2</td>
            <td>Produto 2</td>
            <td>20.00</td>
            <td>unidade</td>
            <td>30</td>
            <td><button type="button" onclick="abrirModal(1)">Alterar</button></td>
        </tr>
        <!-- Outros produtos podem ser listados assim -->
    </tbody>
</table>

<!-- Modal de Edição -->
<div id="modal-edicao">
    <div>
        <span class="close-modal" onclick="fecharModal()">&times;</span>
        <form id="formEdicao" onsubmit="event.preventDefault(); salvarEdicaoModal();">
            <input type="hidden" id="indiceEdicao" />
            <input type="hidden" id="modal-id" />

            <label for="modal-nome">Nome:</label>
            <input id="modal-nome" type="text" required placeholder="Insira o nome do Produto" />

            <label for="modal-validade">Validade:</label>
            <input id="modal-validade" type="date" required />

            <label for="modal-quantidade">Quantidade:</label>
            <input id="modal-quantidade" type="number" required placeholder="Insira a quantidade" />

            <label for="modal-fornecedor">Fornecedor:</label>
            <input id="modal-fornecedor" type="text" required placeholder="Insira o nome do Fornecedor" />

            <label for="modal-unidade">Unidade:</label>
            <select id="modal-unidade" required>
                <option value="" disabled selected>Selecione a unidade</option>
                <option value="kg">kg</option>
                <option value="unidade">unidade</option>
            </select>

            <label for="modal-preco">Preço:</label>
            <input id="modal-preco" type="number" step="0.01" required placeholder="Insira o preço" />

            <button type="submit">Salvar</button>
        </form>
    </div>
</div>

<script>
    // Exemplo de produtos no frontend
    const produtos = [
        {id_produto: 1, nome_produto: "Produto 1", preco: 10.00, unmedida: "kg", quantidade_produto: 50, validade: "2023-12-31", id_fornecedor: "Fornecedor 1"},
        {id_produto: 2, nome_produto: "Produto 2", preco: 20.00, unmedida: "unidade", quantidade_produto: 30, validade: "2024-01-15", id_fornecedor: "Fornecedor 2"}
    ];

    // Função para abrir o modal e preencher os campos
    function abrirModal(indice) {
        const produto = produtos[indice];
        document.getElementById('indiceEdicao').value = indice;
        document.getElementById('modal-id').value = produto.id_produto;
        document.getElementById('modal-nome').value = produto.nome_produto;
        document.getElementById('modal-validade').value = produto.validade;
        document.getElementById('modal-quantidade').value = produto.quantidade_produto;
        document.getElementById('modal-fornecedor').value = produto.id_fornecedor;
        document.getElementById('modal-unidade').value = produto.unmedida;
        document.getElementById('modal-preco').value = produto.preco;

        document.getElementById('modal-edicao').style.display = 'flex';
    }

    // Função para fechar o modal
    function fecharModal() {
        document.getElementById('modal-edicao').style.display = 'none';
    }

    // Função para salvar a edição (apenas no frontend)
    function salvarEdicaoModal() {
        const indice = document.getElementById('indiceEdicao').value;
        const produto = produtos[indice];

        // Atualiza os dados do produto no array
        produto.nome_produto = document.getElementById('modal-nome').value;
        produto.validade = document.getElementById('modal-validade').value;
        produto.quantidade_produto = document.getElementById('modal-quantidade').value;
        produto.id_fornecedor = document.getElementById('modal-fornecedor').value;
        produto.unmedida = document.getElementById('modal-unidade').value;
        produto.preco = document.getElementById('modal-preco').value;

        // Atualiza a tabela com os dados alterados
        atualizarTabela();

        // Fecha o modal
        fecharModal();
    }

    // Função para atualizar a tabela com os dados editados
    function atualizarTabela() {
        const tabela = document.getElementById('tabela-produtos').getElementsByTagName('tbody')[0];
        tabela.innerHTML = ''; // Limpa a tabela

        produtos.forEach((produto, indice) => {
            const row = tabela.insertRow();
            row.setAttribute('data-indice', indice);

            row.innerHTML = `
                <td>${produto.id_produto}</td>
                <td>${produto.nome_produto}</td>
                <td>${produto.preco.toFixed(2).replace('.', ',')}</td>
                <td>${produto.unmedida}</td>
                <td>${produto.quantidade_produto}</td>
                <td><button type="button" onclick="abrirModal(${indice})">Alterar</button></td>
            `;
        });
    }

</script>

</body>
</html>
