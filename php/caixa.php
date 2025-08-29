<?php
session_start();
require_once "conexao.php";

// ID da comanda atual
$id_comanda = $_SESSION['id_comanda'] ?? null;

// Produtos carregados na sessão (para adicionar/remover antes de salvar)
if (!isset($_SESSION['produtos_comanda'])) {
    $_SESSION['produtos_comanda'] = [];
}

// Buscar produtos do banco
$sql = "SELECT * FROM produto ORDER BY nome_produto ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Caixa - Padaria Pão Genial</title>
    <link rel="stylesheet" href="../css/styleCaixa.css">
</head>
<body>
<div class="box_principal">

    <div class="box_header">
        <h2>CAIXA ABERTO - PADARIA PÃO GENIAL 🍞</h2>
    </div>

    <!-- LOGO -->
    <div class="box_logo">
        <img src="../img/logo.png" width="200">
    </div>

    <!-- ID COMANDA -->
    <div class="box_comanda">
        <label>ID da Comanda:</label>
        <input type="text" id="id_comanda" placeholder="Digite o ID da Comanda" value="<?= htmlspecialchars($id_comanda) ?>">
        <button onclick="buscarComanda()" class="buscarComanda">Buscar</button>
        <button onclick="apagarComanda()" class="apagarBuscarComanda">Apagar</button>
    </div>

    <!-- LISTA DE PRODUTOS -->
    <div class="box_listaProdutos">
        <h3>Lista de Produtos</h3>
        <table id="tabela_produtos">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Nome</th>
                    <th>Qtd</th>
                    <th>Vlr. Unit.</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Produtos adicionados via JS -->
            </tbody>
        </table>
    </div>

    <!-- BUSCAR PRODUTO -->
    <div class="box_codigo_prod">
        <label>Código do Produto:</label>
        <input type="text" id="codigo_produto" placeholder="Insira o código...">
        <button onclick="buscarProduto()" class="buscarCodProd">Buscar</button>
    </div>

    <!-- SUBTOTAL -->
    <div class="resumo">
        <div><strong>SUBTOTAL:</strong><span class="destaque" id="subtotal">R$ 0,00</span></div>
    </div>

    <div class="comandos">
        <button>Pesquisar Produto</button>
        <button onclick="abrirModalFinalizar()">Finalizar Venda</button>
        <button onclick="apagarComanda()">Sair</button>
    </div>
</div>

<!-- MODAL FINALIZAR VENDA -->
<div id="modalFinalizar" class="modal" style="display:none;">
    <div class="modal_content">
        <h2>Finalizar Venda</h2>
        <p><strong>Total:</strong> <span id="modal_total">R$ 0,00</span></p>

        <label for="forma_pagamento">Forma de Pagamento:</label>
        <select id="forma_pagamento">
            <option value="Dinheiro">Dinheiro</option>
            <option value="Pix">Pix</option>
            <option value="Vale Alimentação">Vale Alimentação</option>
            <option value="Cartão de Débito">Cartão de Débito</option>
            <option value="Cartão de Crédito">Cartão de Crédito</option>
        </select>

        <div class="botoes_modal">
            <button onclick="confirmarVenda()">Confirmar</button>
            <button onclick="fecharModal()">Cancelar</button>
        </div>
    </div>
</div>

<script>
// Buscar comanda existente
function buscarComanda() {
    let id = document.getElementById("id_comanda").value;
    fetch("buscar_comanda.php?id=" + id)
    .then(res => res.json())
    .then(data => atualizarTabela(data));
}

// Buscar produto pelo código
function buscarProduto() {
    let id = document.getElementById("id_comanda").value;
    let cod = document.getElementById("codigo_produto").value;

    fetch("buscar_produto.php?id=" + id + "&codigo=" + cod)
    .then(res => res.json())
    .then(data => atualizarTabela(data));
}

// Atualiza tabela de produtos
function atualizarTabela(data) {
    let tbody = document.querySelector("#tabela_produtos tbody");
    tbody.innerHTML = "";
    let subtotal = 0;

    if (data.erro) {
        alert(data.erro); 
        return;
    }

    data.forEach((item, i) => {
        subtotal += parseFloat(item.total);

        tbody.innerHTML += `
        <tr>
            <td>${i+1}</td>
            <td>${item.nome_produto}</td>
            <td>${item.quantidade}</td>
            <td>R$ ${parseFloat(item.valor_unit).toFixed(2)}</td>
            <td>R$ ${parseFloat(item.total).toFixed(2)}</td>
            <td><button class="btn_remover" onclick="removerItem(${item.id_item}, ${item.id_comanda})">Remover</button></td>
        </tr>`;
    });

    document.getElementById("subtotal").innerText = "R$ " + subtotal.toFixed(2);
}

// Remover item da comanda
function removerItem(id_item, id_comanda) {
    fetch("remover_item.php?id_item=" + id_item + "&id=" + id_comanda)
    .then(res => res.json())
    .then(data => atualizarTabela(data));
}

// --------------------------------------
// NOVO FLUXO DE FINALIZAR VENDA COM MODAL
// --------------------------------------

// Abre o modal mostrando o total
function abrirModalFinalizar() {
    let subtotal = document.getElementById("subtotal").innerText;
    document.getElementById("modal_total").innerText = subtotal;
    document.getElementById("modalFinalizar").style.display = "block";
}

// Fecha o modal
function fecharModal() {
    document.getElementById("modalFinalizar").style.display = "none";
}

// Confirmar venda
function confirmarVenda() {
    let id = document.getElementById("id_comanda").value;
    let forma = document.getElementById("forma_pagamento").value;

    fetch("finalizar_venda.php?id=" + id + "&forma=" + encodeURIComponent(forma))
    .then(res => res.text())
    .then(msg => {
        alert(msg); // Mostra mensagem de sucesso

        // Abrir nota fiscal em nova aba
        window.open("nota_fiscal.php?id=" + id, "_blank");

        // Limpar caixa
        fecharModal();
        document.querySelector("#tabela_produtos tbody").innerHTML = "";
        document.getElementById("subtotal").innerText = "R$ 0,00";
        document.getElementById("id_comanda").value = "";
    });
}




// Apagar comanda da tela
function apagarComanda() {
    document.querySelector("#tabela_produtos tbody").innerHTML = "";
    document.getElementById("subtotal").innerText = "R$ 0,00";
    document.getElementById("id_comanda").value = "";
}
</script>

</body>
</html>
