

//lista de produtos
const produtos = {
'7891000055128': { nome: 'Pão Francês', preco: 0.80 },
'7891000055555': { nome: 'Café com Leite', preco: 3.50 },
'7891000055999': { nome: 'Pão de Queijo', preco: 1.50 },
'7891000055888': { nome: 'Bolo de Fubá', preco: 4.00 },
'7891000055777': { nome: 'Sonho Recheado', preco: 3.00 },
'7891000055666': { nome: 'Suco Natural', preco: 4.50 },
'7891000056001': { nome: 'Croissant', preco: 3.80 },
'7891000056002': { nome: 'Baguete Integral', preco: 4.20 },
'7891000056003': { nome: 'Pão Doce', preco: 2.50 },
'7891000056004': { nome: 'Coxinha de Frango', preco: 5.00 },
'7891000056005': { nome: 'Pastel de Carne', preco: 4.80 },
'7891000056006': { nome: 'Empada de Frango', preco: 4.20 },
'7891000056007': { nome: 'Torta de Frango', preco: 6.00 },
'7891000056008': { nome: 'Pão de Batata', preco: 2.00 },
'7891000056009': { nome: 'Bolo de Cenoura', preco: 4.00 },
'7891000056010': { nome: 'Bolo de Chocolate', preco: 4.50 },
'7891000056011': { nome: 'Pão Integral', preco: 3.80 },
'7891000056012': { nome: 'Pão de Centeio', preco: 4.00 },
'7891000056013': { nome: 'Pão Multigrãos', preco: 4.50 },
'7891000056014': { nome: 'Torta de Limão', preco: 5.50 },
'7891000056015': { nome: 'Torta de Maçã', preco: 5.50 },
'7891000056016': { nome: 'Bolo Red Velvet', preco: 6.00 },
'7891000056017': { nome: 'Muffin de Chocolate', preco: 3.00 },
'7891000056018': { nome: 'Muffin de Blueberry', preco: 3.50 },
'7891000056019': { nome: 'Brownie Tradicional', preco: 4.00 },
'7891000056020': { nome: 'Brownie com Nozes', preco: 4.50 },
'7891000056021': { nome: 'Cookie de Chocolate', preco: 2.50 },
'7891000056022': { nome: 'Cookie de Aveia', preco: 2.80 },
'7891000056023': { nome: 'Pão de Leite', preco: 1.80 },
'7891000056024': { nome: 'Rosquinha Açucarada', preco: 2.20 },
'7891000056025': { nome: 'Rosquinha de Coco', preco: 2.40 },
'7891000056026': { nome: 'Tapioca Recheada', preco: 5.00 },
'7891000056027': { nome: 'Queijadinha', preco: 2.50 },
'7891000056028': { nome: 'Enroladinho de Salsicha', preco: 3.20 },
'7891000056029': { nome: 'Esfiha de Carne', preco: 4.00 },
'7891000056030': { nome: 'Esfiha de Frango', preco: 4.00 },
'7891000056031': { nome: 'Café Preto', preco: 2.00 },
'7891000056032': { nome: 'Chá Gelado', preco: 3.00 },
'7891000056033': { nome: 'Leite com Chocolate', preco: 3.20 },
'7891000056034': { nome: 'Refrigerante Lata', preco: 4.50 },
'7891000056035': { nome: 'Água Mineral 500ml', preco: 2.50 },
'7891000056036': { nome: 'Água com Gás', preco: 3.00 },
'7891000056037': { nome: 'Sanduíche Natural', preco: 6.00 },
'7891000056038': { nome: 'Sanduíche de Atum', preco: 6.50 },
'7891000056039': { nome: 'Mini Pizza', preco: 5.50 },
'7891000056040': { nome: 'Bauru de Forno', preco: 6.00 },
'7891000056041': { nome: 'Torrada com Alho', preco: 2.50 },
'7891000056042': { nome: 'Pão com Ovo', preco: 3.80 },
'7891000056043': { nome: 'Pão na Chapa', preco: 2.00 },
'7891000056044': { nome: 'Crepioca', preco: 5.00 },
'7891000056045': { nome: 'Panqueca Doce', preco: 4.20 },
'7891000056046': { nome: 'Panqueca Salgada', preco: 4.50 },
'7891000056047': { nome: 'Mini Churros', preco: 3.00 },
'7891000056048': { nome: 'Pão Recheado com Calabresa', preco: 5.50 },
'7891000056049': { nome: 'Pão Recheado com Queijo', preco: 5.00 },
'7891000056050': { nome: 'Pastel de Queijo', preco: 4.80 }

};


let contador = 1;
let subtotal = 0;

document.getElementById('recebido').addEventListener('input', function() {
    const recebido = parseFloat(this.value) || 0;
    const troco = recebido - subtotal;
    document.getElementById('troco').textContent = 'R$' + troco.toFixed(2);
});

function processarProduto(codigo) {
    const quantidade = parseInt(document.getElementById('quantidade').value);
    if (produtos[codigo]) {
        const produto = produtos[codigo];
        adicionarProduto(produto, quantidade);
    }else{
        alert('Produto não encontrado!');
    }     
    }

function adicionarProduto(produto, quantidade) {
    const tabela = document.querySelector('#tabela tbody');
    const row = document.createElement('tr');
    const total = produto.preco * quantidade;

    row.innerHTML = `
        <td>${contador}</td>
        <td>${produto.nome}</td>
        <td>${quantidade}</td>
        <td>R$${produto.preco.toFixed(2)}</td>
        <td>R$${total.toFixed(2)}</td>
        <td><button onclick = "removerProduto(this,${total}">Remover</button></td>
    `;
    tabela.appendChild(row);

    subtotal += total;
    document.getElementById('subtotal').textContent = 'R$' + subtotal.toFixed(2);
    document.getElementById('valorUnit').textContent = produto.preco.toFixed(2);
    document.getElementById('valorItem').textContent = total.toFixed(2);
   contador++; 
}

function removerProduto(button, valor) {
    const row = button.parentElement.parentElement;
    row.remove();
    subtotal -= valor;
    document.getElementById('subtotal').textContent = 'R$' + subtotal.toFixed(2);
    document.getElementById('troco').textContent = 'R$ 0,00';
}

function novaVenda(){
    location.reload();
}

function pesquisarProduto() {
     
}

function cancelarItem() {
    alert('Selecione um item para cancelar!');
  }
  function finalizarVenda() {
    alert('Venda finalizada com sucesso! Troco: ' + document.getElementById('troco').textContent);
    novaVenda();
  }
  function reimprimir() {
    alert('Reimprimindo cupom...');
  }
  function sair() {
    alert('Encerrando sistema...');
  }





