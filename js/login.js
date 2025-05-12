
function login() {
    const username = document.getElementById('username').value;
    localStorage.setItem('username', username); // Salva o nome do usuário
    window.location.href = 'Entrada-caixa.html'; // Redireciona para a página de entrada do caixa

}
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Impede o envio padrão do formulário
    const usuario = document.getElementById('usuario').value;
    const senha = document.getElementById('senha').value;
  
    // Aqui você pode adicionar lógica para validar o login
    if (usuario === "caixa" && senha === "1234") { // Exemplo de validação simples
      window.location.href = "Entrada-caixa.html"; // Redireciona para a página do caixa
    } else {
      alert("Usuário ou senha inválidos!");
    }
  });

