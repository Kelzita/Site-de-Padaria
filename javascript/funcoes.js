/*======= Telefone ======= */
document.addEventListener("DOMContentLoaded", function () {
    Inputmask({"mask": "999.999.999-99", "placeholder": "", showMaskOnHover: false,showMaskOnFocus: false}).mask("#cpf_funcionario");
   Inputmask({"mask": "(99) 99999-9999", "placeholder": "", showMaskOnHover: false,showMaskOnFocus: false}).mask("#telefone_funcionario");
   Inputmask({"mask": "99999-999", "placeholder": "", showMaskOnHover: false,showMaskOnFocus: false}).mask("#cep_funcionario"); // já aproveitei e coloquei para o CEP
   });


/*==== Limite de Data Admissão====*/
const today = new Date().toISOString().split('T')[0];
  document.getElementById('data_admissao').setAttribute('max', today);

/*======= Toggle Senha ======= */ 
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