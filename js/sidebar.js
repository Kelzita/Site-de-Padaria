function toggleMenu() {
    const sidebar = document.getElementById("sidebar");
    sidebar.style.width = sidebar.style.width === "250px" ? "0" : "250px";
  };
  

  function confirmLogout() {
    if (confirm("Você tem certeza que deseja sair?")) {
      // Adicione aqui a lógica para logout, como redirecionar para a página de login
      window.location.href = "Tela de login.html";
    }
  }
