<?php
session_start();
require_once "conexao.php";

if ($_SESSION['id_funcao'] !== 1 && $_SESSION['id_funcao'] !== 4) {
    echo "<script>alert('Acesso Negado!');</script>";

    if (isset($_SESSION['id_funcionario'])) {
        // Usuário está logado -> vai pra home
        echo "<script>window.location.href='../inicio/home.php';</script>";
    } else {
        // Usuário não está logado -> vai pra index (login)
        echo "<script>window.location.href='../index.php';</script>";
    }
    exit;
}


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
        <button onclick="limparTela()" class="apagarBuscarComanda">Limpar</button>
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
    <p>Funcionário(a): <?php echo $_SESSION['nome_funcionario']; ?></p>
    </div>

    <!-- SUBTOTAL -->
    <div class="resumo">
        <div><strong>SUBTOTAL:</strong><span class="destaque" id="subtotal">R$ 0,00</span></div>
    </div>

    <div class="comandos">
        <button onclick="pesquisarProduto()">Pesquisar Produto</button>
        <button onclick="abrirModalFinalizar()">Finalizar Venda</button>
        <button onclick="sairCaixa()">Sair</button>
    </div>
</div>

<!-- MODAL FINALIZAR VENDA -->
<div id="modalFinalizar" class="modal" style="display:none;">
    <div class="modal_content">
        <h2>Finalizar Venda</h2>
        <p><strong>Total:</strong> <span id="modal_total">R$ 0,00</span></p>

        <label for="forma_pagamento">Forma de Pagamento:</label>
        <select id="forma_pagamento">
            <option value="dinheiro">Dinheiro</option>
            <option value="pix">Pix</option>
            <option value="vale alimentação">Vale Alimentação</option>
            <option value="cartao de debito">Cartão de Débito</option>
            <option value="cartao de credito">Cartão de Crédito</option>
        </select>

        <div class="botoes_modal">
            <button onclick="confirmarVenda()">Confirmar</button>
            <button onclick="fecharModal()">Cancelar</button>
        </div>
    </div>
</div>

<script>
    
function pesquisarProduto() {
    let tipo = prompt("Você quer buscar pelo ID ou pelo Nome? (digite 'id' ou 'nome')");
    if (!tipo) return;
    tipo = tipo.toLowerCase();

    if (tipo !== "id" && tipo !== "nome") {
        alert("Opção inválida! Digite 'id' ou 'nome'.");
        return;
    }

    let valor = prompt(`Digite o ${tipo === "id" ? "ID" : "Nome"} do produto:`);
    if (!valor) return;

    let id_comanda = document.getElementById("id_comanda").value;
    if (!id_comanda) {
        alert("Digite o ID da comanda primeiro!");
        return;
    }

    fetch(`buscar_produto_nome_id.php?tipo=${tipo}&valor=${encodeURIComponent(valor)}`)
    .then(res => res.json())
    .then(data => {
        if (data.erro) {
            alert("Produto não cadastrado!");
            return;
        }

        let qtd = prompt("Digite a quantidade:");
        if (!qtd || isNaN(qtd) || qtd <= 0) {
            alert("Quantidade inválida!");
            return;
        }

        fetch(`adicionar_produto.php?id_comanda=${id_comanda}&id_produto=${data.id_produto}&quantidade=${qtd}`)
        .then(res => res.json())
        .then(listaAtualizada => atualizarTabela(listaAtualizada));
    })
    .catch(err => console.error("Erro:", err));
}

// Buscar comanda existente
function buscarComanda() {
    let id = document.getElementById("id_comanda").value;
    fetch("buscar_comanda.php?id=" + id)
    .then(res => res.json())
    .then(data => atualizarTabela(data));
}

function limparTela() {
    // limpa campo de ID da comanda
    document.getElementById("id_comanda").value = "";

    // limpa tabela de produtos
    document.querySelector("#tabela_produtos tbody").innerHTML = "";

    // reseta subtotal
    document.getElementById("subtotal").innerText = "R$ 0,00";
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
    // Pergunta se o usuário tem certeza
    if (!confirm("Tem certeza que deseja remover este item?")) {
        return; // Se clicar em "Cancelar", não faz nada
    }

    fetch("remover_item.php?id_item=" + id_item + "&id=" + id_comanda)
    .then(res => res.json())
    .then(data => atualizarTabela(data));
}

// --------------------------------------
//  FLUXO DE FINALIZAR VENDA COM MODAL
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
        alert(msg);

        // Só abre a nota fiscal se deu sucesso
        if (msg.includes("✅")) {
            window.open("nota_fiscal.php?id=" + id, "_blank");

            // Limpar caixa
            fecharModal();
            document.querySelector("#tabela_produtos tbody").innerHTML = "";
            document.getElementById("subtotal").innerText = "R$ 0,00";
            document.getElementById("id_comanda").value = "";
        }
    })
    .catch(err => {
        alert("❌ Erro de comunicação com o servidor.");
        console.error(err);
    });
}

function sairCaixa() {
    const resposta = confirm("Você tem certeza que deseja sair do caixa?");
    if (resposta) {
        // Se clicou em OK, redireciona
        window.location.href = "../inicio/home.php"; 
    } 
}
</script>

</body>
</html>
