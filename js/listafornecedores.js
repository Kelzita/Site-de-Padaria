document.addEventListener('DOMContentLoaded', () => {
  const tabela = document.getElementById('tabelaFornecedores');
  const modal = document.getElementById('modalEdicao');
  const fecharModalBtn = document.getElementById('fecharModal');
  const formEdicao = document.getElementById('formEdicao');

  function carregarFornecedores() {
    const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];
    
     // Ordena os produtos por ID em ordem crescente
    fornecedores.sort((a, b) => a.id.localeCompare(b.id, undefined, { numeric: true }));
    
    tabela.innerHTML = '';

    fornecedores.forEach((func, index) => {
      const tr = document.createElement('tr');
      const classeInativo = func.ativo === false ? 'style="background-color: #f8d7da;"' : '';

      tr.innerHTML = `
        <tr ${classeInativo}>
          <td>${func.id}</td>
          <td>${func.nome}</td>
          <td>${func.cnpj}</td>
          <td>${func.email}</td>
          <td>${func.telefone}</td>
          <td>${func.ativo === false ? 'Inativo' : 'Ativo'}</td>
          <td>
            <button class="btn-editar" data-index="${index}">
              <i class="fas fa-edit"></i> Editar
            </button>
            <button class="btn-inativar" data-index="${index}">
              <i class="fas fa-${func.ativo === false ? 'redo' : 'ban'}"></i>
              ${func.ativo === false ? 'Reativar' : 'Inativar'}
            </button>
          </td>
        </tr>
      `;

      tabela.appendChild(tr);
    });

    // Eventos de edição
    document.querySelectorAll('.btn-editar').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const idx = e.currentTarget.getAttribute('data-index');
        abrirModalEdicao(idx);
      });
    });

    // Eventos de inativação
    document.querySelectorAll('.btn-inativar').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const idx = e.currentTarget.getAttribute('data-index');
        alternarAtivoFornecedor(idx);
      });
    });
  }

  function abrirModalEdicao(index) {
    const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];
    const fornecedor = fornecedores[index];
    if (!fornecedor) return;

    document.getElementById('indiceEdicao').value = index;
    document.getElementById('nomeEdicao').value = fornecedor.nome;
    document.getElementById('cnpjEdicao').value = fornecedor.cnpj;
    document.getElementById('emailEdicao').value = fornecedor.email;
    document.getElementById('telefoneEdicao').value = fornecedor.telefone;
    modal.style.display = 'flex';
  }

  fecharModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  formEdicao.addEventListener('submit', (e) => {
    e.preventDefault();
    const index = document.getElementById('indiceEdicao').value;
    const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];

    if (!fornecedores[index]) return;

    fornecedores[index] = {
      ...fornecedores[index], // mantém o campo "ativo"
      nome: document.getElementById('nomeEdicao').value,
      cnpj: document.getElementById('cnpjEdicao').value,
      email: document.getElementById('emailEdicao').value,
      telefone: document.getElementById('telefoneEdicao').value,
    };

    localStorage.setItem('fornecedores', JSON.stringify(fornecedores));
    modal.style.display = 'none';
    carregarFornecedores();
  });

  function alternarAtivoFornecedor(index) {
    const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];
    if (!fornecedores[index]) return;

    fornecedores[index].ativo = fornecedores[index].ativo === false ? true : false;
    localStorage.setItem('fornecedores', JSON.stringify(fornecedores));
    carregarFornecedores();
  }

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });

  carregarFornecedores();
});

function filtrar() {
  const filtro = document.getElementById("busca").value.toUpperCase();
  const corpoTabela = document.getElementById("tabelaFornecedores");
  const linhas = corpoTabela.getElementsByTagName("tr");

  for (let i = 0; i < linhas.length; i++) {
    const colunas = linhas[i].getElementsByTagName("td");
    const id = colunas[0]?.textContent.toUpperCase() || "";
    const nome = colunas[1]?.textContent.toUpperCase() || "";

    if (id.includes(filtro) || nome.includes(filtro)) {
      linhas[i].style.display = "";
    } else {
      linhas[i].style.display = "none";
    }
  }
}
