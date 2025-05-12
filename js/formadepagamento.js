document.addEventListener("DOMContentLoaded", function () {
    const botoes = document.querySelectorAll(".painel-botoes .botao");
  
    botoes.forEach((botao) => {
      botao.addEventListener("click", function (event) {
        event.preventDefault(); // Evita que o link tente navegar
  
        // Pegamos apenas o texto sem os ícones
       
        alert("Pagamento Aprovado");
      });
    });
  });
  