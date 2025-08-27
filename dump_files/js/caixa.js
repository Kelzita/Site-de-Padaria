// Número da comanda dinâmico, pega do input
function getNumeroComanda() {
  return document.getElementById('numcomanda').value || "1";
}

// Recupera comandas do localStorage
let comandas = JSON.parse(localStorage.getItem('comandas')) || {};
let numeroComanda = getNumeroComanda();
let comanda = comandas[numeroComanda] || { itens: [] };

let contador = 1;
let subtotal = 0;
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
  
// Função para limpar e carregar a comanda atual no HTML
function carregarComanda() {
  const tabela = document.querySelector('#tabelaProdutos tbody');
  tabela.innerHTML = ''; // limpa tabela
  contador = 1;
  subtotal = 0;

  numeroComanda = getNumeroComanda();
  comandas = JSON.parse(localStorage.getItem('comandas')) || {};
  comanda = comandas[numeroComanda] || { itens: [] };

  comanda.itens.forEach(item => {
    adicionarProduto({nome:item.nome,preco:item.preco}, item, item.quantidade, false);
  });

  document.getElementById('subtotal').textContent = subtotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

// Função processarProduto sem alterações (só adaptando salvar no comanda correta)
function processarProduto(codigo) {
  const quantidade = parseInt(document.getElementById('quantidade').value);
  if (produtos[codigo]) {
    const produto = produtos[codigo];
    adicionarProduto(produto, quantidade, true, codigo);
  } else {
    alert(`Produto com código ${codigo} não encontrado!`);
  }
}

// Função adicionarProduto adaptada para salvar na comanda correta
function adicionarProduto(produto, quantidade, salvar = true, codigo = null) {
  const tabela = document.querySelector('#tabelaProdutos tbody');
  const row = document.createElement('tr');
  const total = produto.preco * quantidade;

  row.innerHTML = `
    <td>${contador}</td>
    <td>${produto.nome}</td>
    <td>${quantidade}</td>
    <td>${produto.preco.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</td>
    <td>${total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</td>
    <td><button onclick="removerProduto(this, ${total})" class="remove">Remover</button></td>
  `;
  tabela.appendChild(row);

  subtotal += total;
  document.getElementById('subtotal').textContent = subtotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

  contador++;

  if (salvar) {
    numeroComanda = getNumeroComanda();
    comandas = JSON.parse(localStorage.getItem('comandas')) || {};
    comanda = comandas[numeroComanda] || { itens: [] };

    comanda.itens.push({
      nome: produto.nome,
      quantidade,
      preco: produto.preco,
      total
    });

    comandas[numeroComanda] = comanda;
    localStorage.setItem('comandas', JSON.stringify(comandas));
  }
}
if (salvar && codigo) {
  numeroComanda = getNumeroComanda();
  comandas = JSON.parse(localStorage.getItem('comandas')) || {};
  comanda = comandas[numeroComanda] || { itens: [] };

  // Verifica se item já existe na comanda
  const itemExistente = comanda.itens.find(item => item.codigo === codigo);
  if (itemExistente) {
    itemExistente.quantidade += quantidade;
  } else {
    comanda.itens.push({ codigo, nome: produto.nome, preco: produto.preco, quantidade });
  }

  comandas[numeroComanda] = comanda;
  localStorage.setItem('comandas', JSON.stringify(comandas));
}


// Função removerProduto atualizada para comanda dinâmica
function removerProduto(button, valor) {
  const senha = prompt("Digite a senha do administrador para remover o item:");

  if (senha === "******") {
    const row = button.parentElement.parentElement;
    const nomeProduto = row.children[1].textContent;
    const quantidade = parseInt(row.children[2].textContent);
    const preco = parseFloat(row.children[3].textContent.replace("R$", "").replace(",", "."));
    row.remove();

    subtotal -= valor;
    document.getElementById('subtotal').textContent = subtotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    // Remove do array da comanda correta
    numeroComanda = getNumeroComanda();
    comandas = JSON.parse(localStorage.getItem('comandas')) || {};
    comanda = comandas[numeroComanda] || { itens: [] };

    const index = comanda.itens.findIndex(item =>
      item.nome === nomeProduto &&
      item.quantidade === quantidade &&
      item.preco === preco
    );

    if (index !== -1) {
      comanda.itens.splice(index, 1);
      comandas[numeroComanda] = comanda;
      localStorage.setItem('comandas', JSON.stringify(comandas));
    }
  } else {
    alert("Senha incorreta. Remoção cancelada.");
  }
}

// Função novaVenda (sem mudanças)
function novaVenda() {
  const confnovavenda = confirm("Você tem certeza que deseja iniciar uma nova venda?");
  if (confnovavenda) {
    localStorage.removeItem('comandas');
    alert("Nova venda iniciada!");
    location.reload();
  } else {
    alert("Venda mantida!");
  }
}

// Função pesquisarProduto (sem mudanças)
function pesquisarProduto() {
  const termo = prompt("Digite o nome do produto:").toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
  if (!termo || termo.trim() === '') {
    alert('Pesquisa cancelada ou inválida.');
    return;
  }

  let produtoEncontrado = null;
  let codigoEncontrado = null;

  for (const codigo in produtos) {
    const nomeNormalizado = produtos[codigo].nome.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    if (nomeNormalizado.includes(termo)) {
      produtoEncontrado = produtos[codigo];
      codigoEncontrado = codigo;
      break;
    }
  }

  if (produtoEncontrado) {
    const qtdStr = prompt(`Produto ${produtoEncontrado.nome} encontrado!\nDigite a quantidade:`)
    const quantidade = parseInt(qtdStr);

    if (!isNaN(quantidade) && quantidade > 0) {
      adicionarProduto(produtoEncontrado, quantidade, true, codigoEncontrado);
      document.getElementById('codigoProduto').value = codigoEncontrado;
    } else {
      alert('Quantidade inválida.');
    }
  } else {
    alert('Produto não encontrado!');
  }
}

// Função finalizarVenda salva no localStorage e redireciona (sem mudanças)
function finalizarVenda() {
  numeroComanda = getNumeroComanda();
  comandas[numeroComanda] = comanda;
  localStorage.setItem('comandas', JSON.stringify(comandas));
  window.location.href = 'FormadePagamento.html';
}

// Função sair (sem mudanças)
function sair() {
  const confsair = confirm("Você tem certeza que deseja sair?");
  if (confsair) {
    alert("Saindo...");
    window.location.href = 'Entrada-caixa.html';
  } else {
    alert("Retornando ao caixa...");
  }
}

// Ao mudar o número da comanda, carrega a nova
document.getElementById('numcomanda').addEventListener('change', carregarComanda);

// Carrega a comanda atual ao abrir a página
window.onload = carregarComanda;
