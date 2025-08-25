function toggleSenha() {
    const inputSenha = document.getElementById("senha");
    const botao = document.getElementById("login-eye");

    if (inputSenha.type === "password") {
        inputSenha.type = "text";
        botao.classList.remove("ri-eye-off-line");
        botao.classList.add("ri-eye-line");
    } else {
        inputSenha.type = "password";
        botao.classList.remove("ri-eye-line");
        botao.classList.add("ri-eye-off-line");
    }
}