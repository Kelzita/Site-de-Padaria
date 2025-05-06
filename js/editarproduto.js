let valoresOriginais = [];  // Para armazenar os valores antes da edição

function carregarProdutos() {
  const produtos = JSON.parse(localStorage.getItem('produtos')) || [];

  // Ordena os produtos por ID em ordem crescente
  produtos.sort((a, b) => a.id.localeCompare(b.id, undefined, { numeric: true }));

  const tabela = document.getElementById('tabelaProdutos');
  tabela.innerHTML = '';

  produtos.forEach((produto, index) => {
    valoresOriginais[index] = { ...produto };  // Guarda os valores originais

    const linha = document.createElement('tr');
    linha.innerHTML = `
      <td>
        <span>${produto.id}</span>
        <input class="input-gerenciar" type="text" value="${produto.id}" style="display:none" />
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
          <button class="btn-editar" onclick="ativarEdicao(this, ${index})">
            <i class="fas fa-edit"></i> Editar
          </button>

          <button class="btn-salvar" style="display:none" onclick="salvarEdicao(this, ${index})">
            <i class="fas fa-save"></i> Salvar
          </button>

          <button class="btn-cancelar" style="display:none" onclick="cancelarEdicao(this)">
            <i class="fas fa-times"></i> Cancelar
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

function ativarEdicao(botaoEditar, index) {
  const linha = botaoEditar.closest('tr');
  linha.querySelectorAll('span').forEach(span => span.style.display = 'none');
  linha.querySelectorAll('.input-gerenciar').forEach(input => input.style.display = 'inline-block');
  linha.querySelector('.btn-editar').style.display = 'none';
  linha.querySelector('.btn-salvar').style.display = 'inline-block';
  linha.querySelector('.btn-cancelar').style.display = 'inline-block';
}

function cancelarEdicao(botaoCancelar) {
  const linha = botaoCancelar.closest('tr');
  const inputs = linha.querySelectorAll('.input-gerenciar');

  // Restaura os valores originais (agora incluindo o id)
  const produtoOriginal = valoresOriginais[linha.rowIndex - 1];
  inputs[0].value = produtoOriginal.id;
  inputs[1].value = produtoOriginal.nome;
  inputs[2].value = produtoOriginal.validade;
  inputs[3].value = produtoOriginal.quantidade;
  inputs[4].value = produtoOriginal.fornecedor;
  inputs[5].value = produtoOriginal.unidade;
  inputs[6].value = produtoOriginal.preco;

  linha.querySelectorAll('span').forEach(span => span.style.display = 'inline');
  linha.querySelectorAll('.input-gerenciar').forEach(input => input.style.display = 'none');
  linha.querySelector('.btn-editar').style.display = 'inline-block';
  linha.querySelector('.btn-salvar').style.display = 'none';
  linha.querySelector('.btn-cancelar').style.display = 'none';
}

function salvarEdicao(botaoSalvar, index) {
  const linha = botaoSalvar.closest('tr');
  const inputs = linha.querySelectorAll('.input-gerenciar');

  const novoProduto = {
    id: inputs[0].value,
    nome: inputs[1].value,
    validade: inputs[2].value,
    quantidade: parseInt(inputs[3].value),
    fornecedor: inputs[4].value,
    unidade: inputs[5].value,
    preco: parseFloat(inputs[6].value).toFixed(2)
  };

  const produtos = JSON.parse(localStorage.getItem('produtos')) || [];
  produtos[index] = novoProduto;
  localStorage.setItem('produtos', JSON.stringify(produtos));
  carregarProdutos();
}

function apagarProduto(index) {
  const produtos = JSON.parse(localStorage.getItem('produtos')) || [];
  if (confirm('Tem certeza que deseja apagar este produto?')) {
    produtos.splice(index, 1);
    localStorage.setItem('produtos', JSON.stringify(produtos));
    carregarProdutos();
  }
}

window.onload = carregarProdutos;
