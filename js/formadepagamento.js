document.addEventListener("DOMContentLoaded", function () {
  const botoes = document.querySelectorAll(".painel-botoes .botao");

  botoes.forEach((botao) => {
    botao.addEventListener("click", function (event) {
      event.preventDefault();
      const textoBotao = botao.textContent.trim().toUpperCase();

      if (textoBotao.includes("PIX")) {
        mostrarQrCode(); // mostra o QR Code se for PIX
      } else {
        abrirModal(); // senão, abre modal normal
      }
    });
  });
});
// ---------------- Funções globais ----------------

function abrirModal() {
  document.getElementById("modal").style.display = "flex";
}

function fecharModal() {
  document.getElementById("modal").style.display = "none";
}

function finalizarVenda() {
  alert("Venda finalizada com sucesso!");
  fecharModal();
}
// Modal QR Code PIX
function mostrarQrCode() {
  document.getElementById("modalQrCode").style.display = "flex";
}

function fecharQrCode() {
  document.getElementById("modalQrCode").style.display = "none";
}




