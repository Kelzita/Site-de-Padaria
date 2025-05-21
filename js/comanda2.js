const produtosPadaria = [
  { nome: "Pão Francês", unidade: "kg" },
  { nome: "Café com Leite", unidade: "un" },
  { nome: "Pão de Queijo", unidade: "kg" },
  { nome: "Bolo de Fubá", unidade: "kg" },
  { nome: "Sonho Recheado", unidade: "un" },
  { nome: "Suco Natural", unidade: "un" },
  { nome: "Croissant", unidade: "kg" },
  { nome: "Baguete Integral", unidade: "kg" },
  { nome: "Pão Doce", unidade: "kg" },
  { nome: "Coxinha de Frango", unidade: "un" },
  { nome: "Pastel de Carne", unidade: "un" },
  { nome: "Empada de Frango", unidade: "un" },
  { nome: "Torta de Frango", unidade: "kg" },
  { nome: "Pão de Batata", unidade: "un" },
  { nome: "Bolo de Cenoura", unidade: "kg" },
  { nome: "Bolo de Chocolate", unidade: "kg" },
  { nome: "Pão Integral", unidade: "un" },
  { nome: "Pão de Centelo", unidade: "un" },
  { nome: "Pão Multigrãos", unidade: "un" },
  { nome: "Torta de Limão", unidade: "kg" },
  { nome: "Torta de Maçã", unidade: "kg" },
  { nome: "Bolo Red Velvet", unidade: "kg" },
  { nome: "Muffin de Chocolate", unidade: "un" },
  { nome: "Muffin de Blueberry", unidade: "kg" },
  { nome: "Brownie Tradicional", unidade: "un" },
  { nome: "Brownie com Nozes", unidade: "kg" },
  { nome: "Cookie de Chocolate", unidade: "un" },
  { nome: "Cookie de Aveia", unidade: "kg" },
  { nome: "Pão de Leite", unidade: "kg" },
  { nome: "Rosquinha Açucarada", unidade: "un" },
  { nome: "Rosquinha de Coco", unidade: "kg" },
  { nome: "Tapioca Recheada", unidade: "un" },
  { nome: "Queijadinha", unidade: "kg" },
  { nome: "Enroladinho de Salsicha", unidade: "un" },
  { nome: "Esfinha de Carne", unidade: "kg" },
  { nome: "Esfinha de Frango", unidade: "kg" },
  { nome: "Café Preto", unidade: "un" },
  { nome: "Chá Gelado", unidade: "un" },
  { nome: "Leite com Chocolate", unidade: "un" },
  { nome: "Refrigerante Lata", unidade: "un" },
  { nome: "Água Mineral 500ml", unidade: "un" },
  { nome: "Água com Gás", unidade: "un" },
  { nome: "Sanduíche de Atum", unidade: "un" },
  { nome: "Mini Pizza", unidade: "un" },
  { nome: "Bauru de Forno", unidade: "kg" },
  { nome: "Torrada com Alho", unidade: "un" },
  { nome: "Pão com Ovo", unidade: "kg" },
  { nome: "Pão na Chapa", unidade: "kg" },
  { nome: "Crepioca", unidade: "un" },
  { nome: "Panqueca Doce", unidade: "un" },
  { nome: "Panqueca Salgada", unidade: "un" },
  { nome: "Mini Churros", unidade: "un" },
  { nome: "Pão Recheado com Calabresa", unidade: "kg" },
  { nome: "Pão Recheado com Queijo", unidade: "kg" },
  { nome: "Pastel de Queijo", unidade: "un" },
];

function carregarProdutos() {
  const container = document.getElementById("listaProdutos");
  container.innerHTML = "";

  produtosPadaria.forEach(prod => {
    const item = document.createElement("div");
    item.className = "item-produto";

    item.innerHTML = `
      <label class="checkbox-label">
        <input type="checkbox" class="checkbox-produto" data-produto="${prod.nome}" data-unidade="${prod.unidade}">
        <span class="checkmark"></span>
      </label>
      <span class="nome-produto">${prod.nome}</span>
      <input type="number" class="quantidade" min="${prod.unidade === 'kg' ? '0.01' : '1'}" step="${prod.unidade === 'kg' ? '0.01' : '1'}" placeholder="Qtd">
      <span class="unidade">${prod.unidade}</span>
      <input type="text" class="observacao" placeholder="Observações">
    `;

    container.appendChild(item);
  });
}

function enviarComanda() {
  const numeroComanda = document.getElementById("inputNumeroComanda").value.trim();

  if (!numeroComanda) {
    alert("Por favor, digite o número da comanda.");
    return;
  }

  const produtosSelecionados = [];
  let erroQuantidade = false;
  let algumProdutoMarcado = false;

  const produtos = document.querySelectorAll('.item-produto');

  produtos.forEach(produto => {
    produto.querySelector('.quantidade').classList.remove("erro");
  });

  produtos.forEach(produto => {
    const checkbox = produto.querySelector('.checkbox-produto');
    const quantidadeInput = produto.querySelector('.quantidade');

    if (checkbox.checked) {
      algumProdutoMarcado = true;

      const quantidade = parseFloat(quantidadeInput.value);
      if (!quantidade || quantidade <= 0) {
        erroQuantidade = true;
        quantidadeInput.classList.add("erro");
      } else {
        produtosSelecionados.push({
          nome: checkbox.dataset.produto,
          quantidade,
          unidade: checkbox.dataset.unidade || "",
          observacao: produto.querySelector('.observacao').value || ""
        });
      }
    }
  });

  if (!algumProdutoMarcado) {
    alert("Por favor, selecione pelo menos um produto.");
    return;
  }

  if (erroQuantidade) {
    alert("Por favor, insira uma quantidade válida para todos os produtos selecionados.");
    return;
  }

  const comanda = {
    numero: numeroComanda,
    produtos: produtosSelecionados
  };

  console.log("Comanda enviada para o caixa:", comanda);
  alert(`Comanda ${numeroComanda} enviada com sucesso!`);

  // Limpar os campos
  document.getElementById("inputNumeroComanda").value = "";
  produtos.forEach(produto => {
    produto.querySelector('.checkbox-produto').checked = false;
    produto.querySelector('.quantidade').value = '';
    produto.querySelector('.observacao').value = '';
  });
}

// Carregar produtos automaticamente ao abrir a página
window.onload = carregarProdutos;
