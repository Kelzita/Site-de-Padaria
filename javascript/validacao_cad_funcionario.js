let nome_funcionario = document.getElementById("nome_funcionario");
let cpf_funcionario = document.getElementById("cpf_funcionario");
let email_funcionario = document.getElementById("email_funcionario");
let telefone_funcionario = document.getElementById("telefone_funcionario");
let cep_funcionario = document.getElementById("cep_funcionario");
let rua_funcionario = document.getElementById("rua_funcionario");
let numero_funcionario = document.getElementById("numero_funcionario");
let bairro_funcionario = document.getElementById("bairro_funcionario");
let cidade_funcionario = document.getElementById("cidade_funcionario");
let uf_funcionario = document.getElementById("uf_funcionario");
let data_admissao = document.getElementById("data_admissao");
let salario = document.getElementById("salario");
let id_funcao = document.getElementById("id_funcao");

// Faz com que a data de admissão seja apenas até o dia atual
let hoje = new Date().toISOString().split("T")[0];
data_admissao.max = hoje;


function ValidacaoFornecedor(event) {

    // Validação de campos vazios
    if(nome_funcionario.value.trim() === "") {
        alert("Preencha o campo Nome!");
        nome_funcionario.focus();
        return false;
    }
    if(nome_funcionario.value.trim().length < 3) {
        alert("O nome deve ter pelo menos 3 caracteres!");
        nome_funcionario.focus();
        return false;
    }

    if(cpf_funcionario.value.trim() === "") {
        alert("Preencha o campo CPF!");
        cpf_funcionario.focus();
        return false;
    }
    if(cpf_funcionario.value.trim().length < 11) {
        alert("O CPF deve ter pelo menos 11 dígitos!");
        cpf_funcionario.focus();
        return false;
    }

    if(email_funcionario.value.trim() === "") {
        alert("Preencha o campo E-mail!");
        email_funcionario.focus();
        return false;
    }

    if(telefone_funcionario.value.trim() === "") {
        alert("Preencha o campo Telefone!");
        telefone_funcionario.focus();
        return false;
    }

    if(cep_funcionario.value.trim() === "") {
        alert("Preencha o campo CEP!");
        cep_funcionario.focus();
        return false;
    }

    if(rua_funcionario.value.trim() === "") {
        alert("Preencha o campo Rua!");
        rua_funcionario.focus();
        return false;
    }

    if(numero_funcionario.value.trim() === "") {
        alert("Preencha o campo Número!");
        numero_funcionario.focus();
        return false;
    }

    if(bairro_funcionario.value.trim() === "") {
        alert("Preencha o campo Bairro!");
        bairro_funcionario.focus();
        return false;
    }

    if(cidade_funcionario.value.trim() === "") {
        alert("Preencha o campo Cidade!");
        cidade_funcionario.focus();
        return false;
    }

    if(!uf_funcionario.value) {
        alert("Selecione o Estado (UF)!");
        uf_funcionario.focus();
        return false;
    }

    if(data_admissao.value === "") {
        alert("Insira uma data de admissão!");
        data_admissao.focus();
        return false;
    }

    if(salario.value.trim() === "") {
        alert("Insira um salário!");
        salario.focus();
        return false;
    }
    if(Number(salario.value) <= 0) {
        alert("O salário deve ser maior que zero!");
        salario.focus();
        return false;
    }

    if(id_funcao.value === "") {
        alert("Selecione uma função!");
        id_funcao.focus();
        return false;
    }

    return true;

    
}
