// Cria múltiplos usuários padrão se ainda não existirem
if (!localStorage.getItem('usuarios')) {
  const usuariosPadrao = [
    {
      id: 1,
      nome: "Genivaldo",
      senha: "12345",
      funcao: "administrador",
      status: "ativo"
    },
    {
      id: 2,
      nome: "Luciana",
      senha: "11111",
      funcao: "caixa",
      status: "ativo"
    },
    {
      id: 3,
      nome: "Pedro",
      senha: "22222",
      funcao: "balconista",
      status: "ativo"
    },
    {
      id: 4,
      nome: "Marta",
      senha: "33333",
      funcao: "gestor de estoque",
      status: "ativo"
    },
    {
      id: 5,
      nome: "Carlos",
      senha: "44444",
      funcao: "administrador",
      status: "inativo"
    }
  ];

  localStorage.setItem('usuarios', JSON.stringify(usuariosPadrao));
  console.log('Usuários padrão criados');
}

// Função de verificação de login
function verificarLogin(event) {
  event.preventDefault(); // Evita envio do formulário

  const nome = document.getElementById("usuario").value.trim();
  const senha = document.getElementById("senha").value.trim();
  const mensagemErro = document.getElementById("mensagemErro");

  if (nome === "" || senha === "") {
    mensagemErro.textContent = "Preencha todos os campos.";
    mensagemErro.style.display = "block";
    return;
  }

  const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];

  const usuarioValido = usuarios.find(u =>
    u.nome === nome &&
    u.senha === senha &&
    u.status === "ativo"
  );

  if (usuarioValido) {
    localStorage.setItem('usuarioLogado', JSON.stringify(usuarioValido));

    // Redirecionamento baseado na função
    switch (usuarioValido.funcao.toLowerCase()) {
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
    }
  } else {
    mensagemErro.textContent = "Usuário ou senha inválidos, ou conta inativa.";
    mensagemErro.style.display = "block";
  }
}

// Ativa a verificação quando o formulário for enviado
document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  form.addEventListener("submit", verificarLogin);
});
