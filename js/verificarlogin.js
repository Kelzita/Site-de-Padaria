function verificarLogin() {
  console.log("Funcionários salvos:", funcionarios);
  const nomeFuncionario = document.getElementById("nome_funcionario").value.trim();
  const senhaFuncionario = document.getElementById("senha_funcionario").value.trim();
  const mensagemErro = document.getElementById("mensagemErro");

  // Oculta mensagem de erro no início
  mensagemErro.style.display = "none";

  if (nomeFuncionario === "" || senhaFuncionario === "") {
    mensagemErro.textContent = "Preencha todos os campos.";
    mensagemErro.style.display = "block";
    return;
  }

  const funcionarios = JSON.parse(localStorage.getItem('funcionarios')) || [];

  // Busca funcionário com nome e senha exatos, e ativo
  const funcionarioValido = funcionarios.find(f =>
    f.nome.trim().toLowerCase() === nomeFuncionario.toLowerCase() &&
    f.senha === senhaFuncionario &&
    (f.ativo === true || f.ativo === "true")
  );
  

  console.log("Digitado:", nomeFuncionario, senhaFuncionario);
  console.log("Funcionários:", funcionarios);
  console.log("Funcionário encontrado:", funcionarioValido);

  if (funcionarioValido) {
    localStorage.setItem('usuarioLogado', JSON.stringify(funcionarioValido));

    // Redireciona com base na função (tratando espaços e caixa)
    const funcao = funcionarioValido.funcao ? funcionarioValido.funcao.trim().toLowerCase() : "";

    switch (funcao) {
      case 'administrador':
        window.location.href = "admreserva.html";
        break;
      case 'caixa':
        window.location.href = "Entrada-caixa.html";
        break;
      case 'balconista':
        window.location.href = "balconista.html";
        break;
      case 'gestor de estoque':
        window.location.href = "gestaoestoque.html";
        break;
      default:
        window.location.href = "home.html";
        break;
    }
  } else {
    alert("Usuário ou senha inválidos.");
    mensagemErro.style.display = "block";
  }
}
