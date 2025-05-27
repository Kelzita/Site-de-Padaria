const produtos = [
  { nome: "Pão Francês", preco: 0.80, unidade: "kg" },
  { nome: "Café com Leite", preco: 3.50, unidade: "un" },
  { nome: "Pão com Queijo", preco: 1.50, unidade: "kg" },
  { nome: "Bolo de Fubá", preco: 4.00, unidade: "kg" },
  { nome: "Sonho Recheado", preco: 3.00, unidade: "un" },
  { nome: "Suco Natural", preco: 5.50, unidade: "un" },
  { nome: "Croissant", preco: 3.80, unidade: "kg" },
  { nome: "Baguete Integral", preco: 4.20, unidade: "kg" },
  { nome: "Pão Doce", preco: 2.50, unidade: "kg" },
  { nome: "Coxinha de Frango", preco: 5.00, unidade: "un" },
  { nome: "Empada de Frango", preco: 4.20, unidade: "un" },
  { nome: "Torta de Frango", preco: 6.00, unidade: "kg" },
  { nome: "Pão de Batata", preco: 2.00, unidade: "un" },
  { nome: "Bolo de Cenoura", preco: 4.00, unidade: "kg" },
  { nome: "Bolo de Chocolate", preco: 4.50, unidade: "kg" },
  { nome: "Pão Integral", preco: 3.80, unidade: "un" },
  { nome: "Pão de Centeio", preco: 4.00, unidade: "un" },
  { nome: "Pão Multigrãos", preco: 4.50, unidade: "un" },
  { nome: "Torta de Limão", preco: 5.50, unidade: "kg" },
  { nome: "Torta de Maçã", preco: 5.50, unidade: "kg" },
  { nome: "Bolo Red Velvet", preco: 6.00, unidade: "kg" },
  { nome: "Muffin de Chocolate", preco: 3.00, unidade: "un" },
  { nome: "Muffin de Blueberry", preco: 3.50, unidade: "un" },
  { nome: "Brownie Tradicional", preco: 4.00, unidade: "un" },
  { nome: "Brownie com Nozes", preco: 3.50, unidade: "kg" },
  { nome: "Cookie de Chocolate", preco: 2.50, unidade: "kg" },
  { nome: "Cookie de Aveia", preco: 2.80, unidade: "kg" },
  { nome: "Pão de Leite", preco: 1.80, unidade: "un" },
  { nome: "Rosquinha Açucarada", preco: 2.20, unidade: "kg" },
  { nome: "Rosquinha de Coco", preco: 2.40, unidade: "kg" },
  { nome: "Tapioca Recheada", preco: 5.00, unidade: "kg" },
  { nome: "Queijadinha", preco: 2.50, unidade: "un" },
  { nome: "Enroladinho de Salsicha", preco: 3.20, unidade: "un" },
  { nome: "Esfiha de Carne", preco: 4.00, unidade: "kg" },
  { nome: "Esfiha de Frango", preco: 4.00, unidade: "kg" },
  { nome: "Café Preto", preco: 2.00, unidade: "un" },
  { nome: "Chá Gelado", preco: 3.00, unidade: "un" },
  { nome: "Leite com Chocolate", preco: 3.20, unidade: "un" },
  { nome: "Refrigerante Lata", preco: 4.50, unidade: "un" },
  { nome: "Água Mineral 500ml", preco: 2.50, unidade: "un" },
  { nome: "Água com Gás", preco: 3.00, unidade: "un" },
  { nome: "Sanduíche Natural", preco: 6.00, unidade: "un" },
  { nome: "Sanduíche de Atum", preco: 6.50, unidade: "un" },
  { nome: "Mini Pizza", preco: 5.50, unidade: "un" },
  { nome: "Bauru de Forno", preco: 6.00, unidade: "un" },
  { nome: "Torrada com Alho", preco: 2.50, unidade: "un" },
  { nome: "Pão com Ovo", preco: 3.80, unidade: "un" },
  { nome: "Pão na Chapa", preco: 2.00, unidade: "un" },
  { nome: "Crepioca", preco: 5.00, unidade: "un" },
  { nome: "Panqueca Doce", preco: 4.20, unidade: "un" },
  { nome: "Panqueca Salgada", preco: 4.50, unidade: "un" },
  { nome: "Mini Churros", preco: 3.00, unidade: "kg" },
  { nome: "Pão Recheado com Calabresa", preco: 5.50, unidade: "un" },
  { nome: "Pão Recheado com Queijo", preco: 5.00, unidade: "un" },
  { nome: "Pastel de Queijo", preco: 4.80, unidade: "un" },
];

function criarListaProdutos(filtro = "") {
  const container = document.getElementById('listaProdutos');
  container.innerHTML = "";

  produtos
    .filter(p => p.nome.toLowerCase().includes(filtro.toLowerCase()))
    .forEach(prod => {
      const item = document.createElement('div');
      item.className = 'item-produto';
      item.innerHTML = `
        <input type="checkbox" class="checkbox-produto">
        <span class="nome-produto">${prod.nome}</span>
        <span class="preco-unit">R$ ${prod.preco.toFixed(2).replace('.', ',')}/${prod.unidade}</span>
        <input type="number" class="quantidade" min="0.01" step="0.01" placeholder="Qtd" disabled>
        <input type="text" class="observacao" placeholder="Obs." disabled>
      `;
      container.appendChild(item);

      const checkbox = item.querySelector('.checkbox-produto');
      const inputQtd = item.querySelector('.quantidade');
      const inputObs = item.querySelector('.observacao');

      checkbox.addEventListener('change', () => {
        const habilitado = checkbox.checked;
        inputQtd.disabled = !habilitado;
        inputObs.disabled = !habilitado;
        if (!habilitado) {
          inputQtd.value = "";
          inputObs.value = "";
        }
      });
    });
}

function enviarComanda() {
  const numeroComanda = document.getElementById("inputNumeroComanda").value.trim();
  if (!numeroComanda) {
    alert("Por favor, preencha o número da comanda.");
    return;
  }

  const produtosSelecionados = [];

  document.querySelectorAll('.item-produto').forEach(item => {
    const checkbox = item.querySelector('.checkbox-produto');
    const nome = item.querySelector('.nome-produto').textContent;
    const quantidade = item.querySelector('.quantidade').value.trim();
    const observacao = item.querySelector('.observacao').value.trim();

    if (checkbox.checked) {
      if (!quantidade || parseFloat(quantidade) <= 0) {
        alert(`Informe a quantidade para o(s) produto(s)`);
        return;
      }

      produtosSelecionados.push({
        nome,
        quantidade: parseFloat(quantidade),
        observacao
      });
    }
  });

  if (produtosSelecionados.length === 0) {
    alert("Selecione ao menos um produto com quantidade.");
    return;
  }

  const comanda = {
    numero: numeroComanda,
    produtos: produtosSelecionados,
    data: new Date().toISOString()
  };

  const comandas = JSON.parse(localStorage.getItem('comandas')) || {};
  comandas[numeroComanda] = comanda;
  localStorage.setItem('comandas', JSON.stringify(comandas));

  alert("Comanda enviada para o caixa!");
  
  // Redireciona para o caixa passando o número da comanda na URL
  window.location.href = `caixa_caixa.html?comanda=${encodeURIComponent(numeroComanda)}`;
}

window.onload = () => {
  criarListaProdutos();
  document.getElementById('pesquisaProduto').addEventListener('input', e => {
    criarListaProdutos(e.target.value);
  });
};
