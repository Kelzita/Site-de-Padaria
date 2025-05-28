document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  const toggleSenhaBtn = document.getElementById('toggleSenha');
  const senhaInput = document.getElementById('senha_funcionario');
  const mensagemErro = document.getElementById('mensagemErro');

  // Toggle mostrar/esconder senha
  toggleSenhaBtn.addEventListener('click', () => {
    if (senhaInput.type === 'password') {
      senhaInput.type = 'text';
      toggleSenhaBtn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
    } else {
      senhaInput.type = 'password';
      toggleSenhaBtn.innerHTML = '<i class="fa-solid fa-eye"></i>';
    }
  });

  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      verificarLogin();
    });
  }

  function verificarLogin() {
    mensagemErro.style.display = 'none'; // esconde mensagem no começo

    const nomeFuncionario = document.getElementById("nome_funcionario").value.trim();
    const senhaFuncionario = document.getElementById("senha_funcionario").value.trim();

    if (!nomeFuncionario || !senhaFuncionario) {
      mensagemErro.textContent = "Preencha todos os campos.";
      mensagemErro.style.display = "block";
      return;
    }

    const funcionarios = JSON.parse(localStorage.getItem('funcionarios')) || [];

    const funcionario = funcionarios.find(f =>
      f.nome.trim().toLowerCase() === nomeFuncionario.toLowerCase()
    );

    if (!funcionario) {
      alert("Funcionário não encontrado.");
      mensagemErro.style.display = "block";
      return;
    }

    if (funcionario.ativo !== true && funcionario.ativo !== "true") {
      alert("Funcionário inativo. Acesso não permitido.");
      mensagemErro.style.display = "block";
      return;
    }

    if (funcionario.senha !== senhaFuncionario) {
      alert("Usuário ou senha incorreta.");
      mensagemErro.style.display = "block";
      return;
    }

    // Tudo certo: login válido
    localStorage.setItem('usuarioLogado', JSON.stringify(funcionario));

    const funcao = funcionario.funcao ? funcionario.funcao.trim().toLowerCase() : "";

    switch (funcao) {
      case 'administrador':
        window.location.href = "admreserva.html";
        break;
      case 'caixa':
        window.location.href = "Entrada-caixa.html";
        break;
      case 'balconista':
        window.location.href = "entrada_comanda.html";
        break;
      case 'gestor de estoque':
        window.location.href = "gestaoestoque.html";
        break;
      default:
        window.location.href = "Tela de Login.html";
        break;
    }
  }
});
