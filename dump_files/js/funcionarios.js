let funcionarios = [
  {
    id: 1,
    nome: "João da Silva",
    funcao: "Caixa",
    senha: "123456",
    telefone: "11999999999",
    salario: 1500,
    cpf: "12345678900",
    email: "joao@email.com",
    rg: "12345678",
    ativo: true
  }
];

let funcionarioEditando = null;

function carregarFuncionarios() {
  const tbody = document.getElementById("corpoTabelaFunc");
  tbody.innerHTML = "";

  funcionarios.forEach(func => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${func.id}</td>
      <td>${func.nome}</td>
      <td>${func.funcao}</td>
      <td>${func.ativo ? "Ativo" : "Inativo"}</td>
      <td>${func.telefone}</td>
      <td>R$ ${parseFloat(func.salario).toFixed(2)}</td>
      <td>${func.cpf}</td>
      <td>${func.email}</td>
      <td>${func.rg}</td>
      <td>
        <button onclick="abrirEdicao(${func.id})"><i class="fas fa-edit"></i></button>
        <button onclick="alternarStatus(${func.id})">
          <i class="fas ${func.ativo ? 'fa-user-slash' : 'fa-user-check'}"></i>
        </button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

function filtrarFuncionarios() {
  const termo = document.getElementById("busca").value.toLowerCase();
  const linhas = document.querySelectorAll("#corpoTabelaFunc tr");
  linhas.forEach(linha => {
    const nome = linha.cells[1].textContent.toLowerCase();
    linha.style.display = nome.includes(termo) ? "" : "none";
  });
}

function abrirEdicao(id) {
  const func = funcionarios.find(f => f.id === id);
  if (!func) return;
  funcionarioEditando = func;
  document.getElementById("editNome").value = func.nome;
  document.getElementById("editFuncao").value = func.funcao;
  document.getElementById("editSenha").value = func.senha;
  document.getElementById("editTelefone").value = func.telefone;
  document.getElementById("editSalario").value = func.salario;

  document.getElementById("modal-edicao").classList.remove("hidden");
}

function salvarEdicao() {
  if (!funcionarioEditando) return;
  funcionarioEditando.nome = document.getElementById("editNome").value;
  funcionarioEditando.funcao = document.getElementById("editFuncao").value;
  funcionarioEditando.senha = document.getElementById("editSenha").value;
  funcionarioEditando.telefone = document.getElementById("editTelefone").value;
  funcionarioEditando.salario = parseFloat(document.getElementById("editSalario").value);

  fecharModal();
  carregarFuncionarios();
}

function alternarStatus(id) {
  const func = funcionarios.find(f => f.id === id);
  if (!func) return;
  func.ativo = !func.ativo;
  carregarFuncionarios();
}

function fecharModal() {
  document.getElementById("modal-edicao").classList.add("hidden");
  funcionarioEditando = null;
}

function toggleSenhaEdit(icone) {
  const input = document.getElementById("editSenha");
  const tipo = input.type === "password" ? "text" : "password";
  input.type = tipo;
  icone.classList.toggle("fa-eye-slash");
}

window.onload = carregarFuncionarios;
