let valoresOriginais = [];

function carregarProdutos() {
  const tabela = document.getElementById('tabelaProdutos');
  tabela.innerHTML = ''; // limpa antes de carregar

  const produtos = JSON.parse(localStorage.getItem('produtos')) || [];
  valoresOriginais = JSON.parse(JSON.stringify(produtos)); // Clona para restauração

  produtos.forEach((produto, index) => {
    const linha = document.createElement('tr');
    linha.innerHTML = `
      <td>
        <span>${produto.id}</span>
        <input class="input-gerenciar" type="text" value="${produto.id}" style="display:none" readonly />
      </td>
      <td>
        <span>${produto.nome}</span>
        <input class="input-gerenciar" type="text" value="${produto.nome}" style="display:none" />
      </td>
      <td>
        <span>${produto.validade}</span>
        <input class="input-gerenciar" type="date" value="${produto.validade}" style="display:none" />
      </td>
      <td>
        <span>${produto.quantidade}</span>
        <input class="input-gerenciar" type="number" value="${produto.quantidade}" style="display:none" />
      </td>
      <td>
        <span>${produto.fornecedor}</span>
        <input class="input-gerenciar" type="text" value="${produto.fornecedor}" style="display:none" />
      </td>
      <td>
        <span>${produto.unidade}</span>
        <select class="input-gerenciar" style="display:none">
          <option value="kg" ${produto.unidade === 'kg' ? 'selected' : ''}>kg</option>
          <option value="unidade" ${produto.unidade === 'unidade' ? 'selected' : ''}>unidade</option>
        </select>
      </td>
      <td>
        <span>R$ ${parseFloat(produto.preco).toFixed(2)}</span>
        <input class="input-gerenciar" type="number" step="0.01" value="${produto.preco}" style="display:none" />
      </td>
      <td class="acoes">
        <div class="grupo-botoes">
          <button class="btn-editar" onclick="abrirModalEdicao(${index})">
            <i class="fas fa-edit"></i> Editar
          </button>
          <button class="btn-apagar" onclick="apagarProduto(${index})">
            <i class="fas fa-trash-alt"></i> Apagar
          </button>
        </div>
      </td>
    `;
    tabela.appendChild(linha);
  });
}

function abrirModalEdicao(index) {
  const produtos = JSON.parse(localStorage.getItem('produtos')) || [];
  const produto = produtos[index];
  
  if (!produto) return;

  // Preencher inputs do modal
  document.getElementById('modal-id').value = produto.id;
  document.getElementById('modal-nome').value = produto.nome;
  document.getElementById('modal-validade').value = produto.validade;
  document.getElementById('modal-quantidade').value = produto.quantidade;
  document.getElementById('modal-fornecedor').value = produto.fornecedor;
  document.getElementById('modal-unidade').value = produto.unidade;
  document.getElementById('modal-preco').value = produto.preco;

  // Guardar índice para salvar
  const modal = document.getElementById('modal');
  modal.dataset.produtoIndex = index;

  // Mostrar modal
  modal.style.display = 'block';
}


function salvarEdicaoModal() {
  const index = parseInt(document.getElementById('modal').dataset.produtoIndex);
  const produtos = JSON.parse(localStorage.getItem('produtos')) || [];

  const produtoAtualizado = {
    id: document.getElementById('modal-id').value.trim(),
    nome: document.getElementById('modal-nome').value.trim(),
    validade: document.getElementById('modal-validade').value,
    quantidade: parseInt(document.getElementById('modal-quantidade').value),
    fornecedor: document.getElementById('modal-fornecedor').value.trim(),
    unidade: document.getElementById('modal-unidade').value,
    preco: parseFloat(document.getElementById('modal-preco').value).toFixed(2),
  };

  if (!produtoAtualizado.nome || isNaN(produtoAtualizado.quantidade) || isNaN(produtoAtualizado.preco)) {
    alert("Preencha todos os campos corretamente.");
    return;
  }

  produtos[index] = produtoAtualizado;
  localStorage.setItem('produtos', JSON.stringify(produtos));

  fecharModal();
  carregarProdutos();
}

function fecharModal() {
  document.getElementById('modal').style.display = 'none';
}

function apagarProduto(index) {
  const produtos = JSON.parse(localStorage.getItem('produtos')) || [];
  if (confirm('Tem certeza que deseja apagar este produto?')) {
    produtos.splice(index, 1);
    localStorage.setItem('produtos', JSON.stringify(produtos));
    carregarProdutos();
  }
}

function filtrar() {
  const filtro = document.getElementById("busca").value.toUpperCase();
  const corpoTabela = document.getElementById("tabelaProdutos");
  const linhas = corpoTabela.getElementsByTagName("tr");

  for (let i = 0; i < linhas.length; i++) {
    const colunas = linhas[i].getElementsByTagName("td");

    const spanId = colunas[0].querySelector("span")?.textContent.toUpperCase() || "";
    const inputId = colunas[0].querySelector("input")?.value.toUpperCase() || "";
    const id = spanId || inputId;

    const spanNome = colunas[1].querySelector("span")?.textContent.toUpperCase() || "";
    const inputNome = colunas[1].querySelector("input")?.value.toUpperCase() || "";
    const nome = spanNome || inputNome;

    if (id.includes(filtro) || nome.includes(filtro)) {
      linhas[i].style.display = "";
    } else {
      linhas[i].style.display = "none";
    }
  }
}

window.onload = carregarProdutos;