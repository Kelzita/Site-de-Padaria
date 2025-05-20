function verificarLogin() {
    const nomeFuncionario = document.getElementById("nome_funcionario").value.trim();
    const senhaFuncionario = document.getElementById("senha_funcionario").value.trim();
    const mensagemErro = document.getElementById("mensagemErro");
  
    if (senhaFuncionario === "" || nomeFuncionario === "") {
      mensagemErro.style.display = "block";
      return;
    }
  
    const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
  
    const usuarioValido = usuarios.find(u =>
      u.nome === nomeFuncionario &&
      u.senha === senhaFuncionario &&
      u.status === 'ativo'
    );
  
    if (usuarioValido) {
      localStorage.setItem('usuarioLogado', JSON.stringify(usuarioValido));
  
      // Redirecionamento baseado no cargo/função
      switch (usuarioValido.cargo?.toLowerCase()) {
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
          window.location.href = "home.html"; // fallback
      }
    } else {
      mensagemErro.style.display = "block";
    }
  }
  