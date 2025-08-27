const sidebar = document.getElementById("sidebar");
const menuBtn = document.getElementById("menu-btn");

function toggleSidebar() {
  if (sidebar.style.width === "250px") {
    sidebar.style.width = "0";
    menuBtn.classList.remove("active");
  } else {
    sidebar.style.width = "250px";
    menuBtn.classList.add("active");
  }
}

menuBtn.addEventListener("click", function(event) {
  event.stopPropagation(); // Evita fechamento imediato ao clicar no botão
  toggleSidebar();
});

window.addEventListener("click", function(event) {
  // Fecha sidebar ao clicar fora dela e do botão
  if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
    sidebar.style.width = "0";
    menuBtn.classList.remove("active");
  }
});

function confirmLogout() {
  if (confirm("Você tem certeza que deseja sair?")) {
    window.location.href = "Tela de login.html";
  }
}
