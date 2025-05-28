document.addEventListener('DOMContentLoaded', () => {
  const tabela = document.getElementById('tabelaProdutos');
  const modal = document.getElementById('modalEdicao');
  const fecharModalBtn = document.getElementById('fecharModal');
  const formEdicao = document.getElementById('formEdicao');

  function carregarFuncionarios() {
    const funcionarios = JSON.parse(localStorage.getItem('funcionarios')) || [];
    const existeGenivaldo = funcionarios.some(func => func.funcao === 'Administrador'); 
    tabela.innerHTML = '';
      if (!existeGenivaldo) {
        funcionarios.push({
          nome: "Genivaldo",
          cpf: "12345678900",
          rg: "7859462318",
          senha: "admin123",
          email: "genivaldoSilva@email.com",
          telefone: "(31) 92379-9792",
          rua: "Rua das Flores",
          numero: "100",
          bairro: "Centro",
          cidade: "Belo Horizonte",
          uf: "SC",
          funcao: "Administrador",
          admissao: "2023-01-01",
          salario: "3500.00",
          ativo: true
        });
    
        localStorage.setItem('funcionarios', JSON.stringify(funcionarios));
      }
    
    

    funcionarios.forEach((func, index) => {
      const tr = document.createElement('tr');
      const classeInativo = func.ativo === false ? 'style="background-color: #f8d7da;"' : '';

      tr.innerHTML = `
        <tr ${classeInativo}>
          <td>${index + 1}</td>
          <td>${func.nome}</td>
          <td>${func.cpf}</td>
          <td>${func.rg}</td>
          <td>${'*'.repeat(func.senha.length)}</td>
          <td>${func.email}</td>
          <td>${func.telefone}</td>
          <td>${func.rua}</td>
          <td>${func.numero}</td>
          <td>${func.bairro}</td>
          <td>${func.cidade}</td>
          <td>${func.uf}</td>
          <td>${func.funcao}</td>
          <td>${func.admissao}</td>
          <td>${parseFloat(func.salario).toFixed(2)}</td>
          <td>${func.ativo === false ? 'Inativo' : 'Ativo'}</td>
          <td>
            <button class="btn-editar" data-index="${index}">
              <i class="fas fa-edit"></i> Editar
            </button>
            <button class="btn-inativar" data-index="${index}">
              <i class="fas fa-${func.ativo === false ? 'redo' : 'ban'}"></i> ${func.ativo === false ? 'Reativar' : 'Inativar'}
            </button>
            <button class="btn-excluir" data-index="${index}">
              <i class="fas fa-trash"></i> Excluir
            </button>
          </td>
        </tr>
      `;

      tabela.appendChild(tr);
    });

    // Eventos dos botões
    document.querySelectorAll('.btn-editar').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const idx = e.currentTarget.getAttribute('data-index');
        abrirModalEdicao(idx);
      });
    });

    document.querySelectorAll('.btn-inativar').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const idx = e.currentTarget.getAttribute('data-index');
        alternarAtivoFuncionario(idx);
      });
    });

    document.querySelectorAll('.btn-excluir').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const idx = e.currentTarget.getAttribute('data-index');
        excluirFuncionario(idx);
      });
    });
  }

  function abrirModalEdicao(index) {
    const funcionarios = JSON.parse(localStorage.getItem('funcionarios')) || [];
    const func = funcionarios[index];
    if (!func) return;

    document.getElementById('indiceEdicao').value = index;
    document.getElementById('nomeEdicao').value = func.nome;
    document.getElementById('cpfEdicao').value = func.cpf;
    document.getElementById('rgEdicao').value = func.rg;
    document.getElementById('senhaEdicao').value = func.senha;
    document.getElementById('emailEdicao').value = func.email;
    document.getElementById('telefoneEdicao').value = func.telefone;
    document.getElementById('ruaEdicao').value = func.rua;
    document.getElementById('numeroEdicao').value = func.numero;
    document.getElementById('bairroEdicao').value = func.bairro;
    document.getElementById('cidadeEdicao').value = func.cidade;
    document.getElementById('ufEdicao').value = func.uf;
    document.getElementById('funcaoEdicao').value = func.funcao;
    document.getElementById('admissaoEdicao').value = func.admissao;
    document.getElementById('salarioEdicao').value = func.salario;

    modal.style.display = 'flex';
  }

  fecharModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  formEdicao.addEventListener('submit', (e) => {
    e.preventDefault();
    const index = document.getElementById('indiceEdicao').value;
    const funcionarios = JSON.parse(localStorage.getItem('funcionarios')) || [];

    if (!funcionarios[index]) return;

    funcionarios[index] = {
      ...funcionarios[index],
      nome: document.getElementById('nomeEdicao').value,
      cpf: document.getElementById('cpfEdicao').value,
      rg: document.getElementById('rgEdicao').value,
      senha: document.getElementById('senhaEdicao').value,
      email: document.getElementById('emailEdicao').value,
      telefone: document.getElementById('telefoneEdicao').value,
      rua: document.getElementById('ruaEdicao').value,
      numero: document.getElementById('numeroEdicao').value,
      bairro: document.getElementById('bairroEdicao').value,
      cidade: document.getElementById('cidadeEdicao').value,
      uf: document.getElementById('ufEdicao').value,
      funcao: document.getElementById('funcaoEdicao').value,
      admissao: document.getElementById('admissaoEdicao').value,
      salario: document.getElementById('salarioEdicao').value
    };

    localStorage.setItem('funcionarios', JSON.stringify(funcionarios));
    modal.style.display = 'none';
    carregarFuncionarios();
  });

  function alternarAtivoFuncionario(index) {
    const funcionarios = JSON.parse(localStorage.getItem('funcionarios')) || [];
    if (!funcionarios[index]) return;

    funcionarios[index].ativo = funcionarios[index].ativo === false ? true : false;
    localStorage.setItem('funcionarios', JSON.stringify(funcionarios));
    carregarFuncionarios();
  }

  function excluirFuncionario(index) {
    const confirmacao = confirm("Tem certeza que deseja excluir este funcionário?");
    if (!confirmacao) return;

    const funcionarios = JSON.parse(localStorage.getItem('funcionarios')) || [];
    if (!funcionarios[index]) return;

    funcionarios.splice(index, 1);
    localStorage.setItem('funcionarios', JSON.stringify(funcionarios));
    carregarFuncionarios();
  }

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });

  carregarFuncionarios();
});

// Função de filtro
function filtrar() {
  const filtro = document.getElementById("busca").value.toUpperCase();
  const linhas = document.querySelectorAll("#tabelaProdutos tr");

  linhas.forEach(linha => {
    const idColuna = linha.querySelector("td:first-child"); // Coluna do ID
    const nomeColuna = linha.querySelector("td:nth-child(2)"); // Coluna do Nome
    let encontrado = false;

    if (idColuna && idColuna.textContent.toUpperCase().includes(filtro)) {
      encontrado = true;
    }

    if (nomeColuna && nomeColuna.textContent.toUpperCase().includes(filtro)) {
      encontrado = true;
    }

    linha.style.display = encontrado ? "" : "none";
  });
}
const toggleSenhaBtn = document.getElementById('toggleSenha');
const senhaInput = document.getElementById('senhaEdicao');
const icon = toggleSenhaBtn.querySelector('i');

toggleSenhaBtn.addEventListener('click', () => {
  if (senhaInput.type === 'password') {
    senhaInput.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    senhaInput.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
});