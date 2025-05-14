// js/login.js

function toggleMenu() {
  const sidebar = document.getElementById("sidebar");
  sidebar.style.width = (sidebar.style.width === "250px") ? "0" : "250px";
}


document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const usuarioInput = document.getElementById("usuario");
  const senhaInput = document.getElementById("senha");

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const usuario = usuarioInput.value.trim();
    const senha = senhaInput.value;

    const credenciaisValidas = {
      usuario: "admin",
      senha: "1234"
    };

    if (!usuario || !senha) {
      alert("Preencha todos os campos.");
      return;
    }

    if (usuario === credenciaisValidas.usuario && senha === credenciaisValidas.senha) {
      alert("Login bem-sucedido!");
      window.location.href = "admreserva.html";
    } else {
      alert("Usuário ou senha inválidos.");
    }
  });
});
