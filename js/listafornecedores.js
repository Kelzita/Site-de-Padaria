let valoresOriginais = [];  // Para armazenar os valores antes da edição

function carregarFornecedores() {
  const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];

  // Ordena os fornecedores por ID em ordem crescente
  fornecedores.sort((a, b) => a.id.localeCompare(b.id, undefined, { numeric: true }));

  const tabela = document.getElementById('tabelaFornecedores');
  tabela.innerHTML = '';

  fornecedores.forEach((fornecedor, index) => {
    valoresOriginais[index] = { ...fornecedor };  // Guarda os valores originais

    const linha = document.createElement('tr');
    linha.innerHTML = `
      <td>
        <span>${fornecedor.id}</span>
        <input class="input-gerenciar" type="text" value="${fornecedor.id}" style="display:none" />
      </td>
      <td>
        <span>${fornecedor.nome}</span>
        <input class="input-gerenciar" type="text" value="${fornecedor.nome}" style="display:none" />
      </td>
      <td>
        <span>${fornecedor.cnpj}</span>
        <input class="input-gerenciar" type="date" value="${fornecedor.cnpj}" style="display:none" />
      </td>
      <td>
        <span>${fornecedor.email}</span>
        <input class="input-gerenciar" type="number" value="${fornecedor.email}" style="display:none" />
      </td>
      <td>
        <span>${fornecedor.telefone}</span>
        <input class="input-gerenciar" type="text" value="${fornecedor.telefone}" style="display:none" />
      </td>
      <td>
   
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
  const fornecedorOriginal = valoresOriginais[linha.rowIndex - 1];
  inputs[0].value = fornecedorOriginal.id;
  inputs[1].value = fornecedorOriginal.nome;
  inputs[2].value = fornecedorOriginal.cnpj;
  inputs[3].value = fornecedorOriginal.email;
  inputs[4].value = fornecedorOriginal.telefone;

  linha.querySelectorAll('span').forEach(span => span.style.display = 'inline');
  linha.querySelectorAll('.input-gerenciar').forEach(input => input.style.display = 'none');
  linha.querySelector('.btn-editar').style.display = 'inline-block';
  linha.querySelector('.btn-salvar').style.display = 'none';
  linha.querySelector('.btn-cancelar').style.display = 'none';
}

function salvarEdicao(botaoSalvar, index) {
    const linha = botaoSalvar.closest('tr');
    const inputs = linha.querySelectorAll('.input-gerenciar');
  
    const novoFornecedor = {
      id: inputs[0].value,
      nome: inputs[1].value,
      cnpj: inputs[2].value,
      email: inputs[3].value,
      telefone: inputs[4].value,
    };
  
    const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];
    fornecedores[index] = novoFornecedor;  // Corrigido aqui
    localStorage.setItem('fornecedores', JSON.stringify(fornecedores));
    carregarFornecedores();
  }
  
function apagarFornecedor(index) {
  const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];
  if (confirm('Tem certeza que deseja inativar este fornecedor?')) {
    fornecedores.splice(index, 1);
    localStorage.setItem('fornecedores', JSON.stringify(fornecedores));
    carregarFornecedores();
  }
}

function filtrar() {
  const filtro = document.getElementById("busca").value.toUpperCase();
  const corpoTabela = document.getElementById("tabelaFornecedores");
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


window.onload = carregarFornecedores;
