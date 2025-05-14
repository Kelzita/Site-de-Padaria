document.addEventListener("DOMContentLoaded", function () {
    const botoes = document.querySelectorAll(".painel-botoes .botao");
  
    botoes.forEach((botao) => {
      botao.addEventListener("click", function (event) {
        event.preventDefault(); // Evita que o link tente navegar
  
        // Pegamos apenas o texto sem os ícones
       
        alert("Pagamento Aprovado");
      });
    });
   // Função para abrir o modal
function abrirModal() {
  document.getElementById('modal').style.display = 'flex';
}

// Função para fechar o modal
function fecharModal() {
  document.getElementById('modal').style.display = 'none';
}

// Função para finalizar a venda
function finalizarVenda() {
  alert('Venda finalizada com sucesso!');
  fecharModal(); // Fecha o modal após finalizar a venda
}

    
  });


