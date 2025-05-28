document.addEventListener("DOMContentLoaded", function () {
  const botoes = document.querySelectorAll(".painel-botoes .botao");

  botoes.forEach((botao) => {
    botao.addEventListener("click", function (event) {
      event.preventDefault();
      const textoBotao = botao.innerText.trim().toUpperCase();

      if (textoBotao.includes("PIX")) {
        mostrarQrCode();
      } else {
        abrirModal();
      }
    });
  });
});

function abrirModal() {
  document.getElementById("modal").style.display = "flex";
}

function fecharModal() {
  document.getElementById("modal").style.display = "none";
  
}

function finalizarVenda() {
  alert("Venda finalizada com sucesso!");
  fecharModal();
  window.location.href = "caixa_caixa.html";
}


function mostrarQrCode() {
  document.getElementById("modalQrCode").style.display = "flex";
}
function irParaCaixa() {
  alert("Pagamento via PIX confirmado!");
  window.location.href = "caixa_caixa.html";
}
function fecharQrCode() {
  document.getElementById("modalQrCode").style.display = "none";
}
