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

function ValidacaoFornecedor(event) {
   
    //============ Validação para campos vazios ============ 
    

    if(nome_funcionario.value.trim() === "") {
        alert("Preencha o campo Nome!");
        razao_social.focus();
        return false;
    }
    if(cpf_funcionario.value.trim() === "") {
        alert("Preencha o campo CNPJ!");
        cnpj_fornecedor.focus();
        return false;
    };
    
    if(email_funcionario.value.trim() === "") {
        alert("Preencha o campo Telefone!");
        telefone_fornecedor.focus();
        return false;
    }
    
    if(telefone_funcionario.value.trim() === "") {
        alert("Preencha o campo E-mail!");
        email_fornecedor.focus();
        return false;
    }
    if(cep_fornecedor.value.trim() === "") {
        alert("Preencha o campo CEP!");
        cep_fornecedor.focus();
        return false;
    }
    if(rua_fornecedor.value.trim() === "") {
        alert("Preencha o campo Rua!");
        rua_fornecedor.focus();
        return false;
    }
    if(numero_fornecedor.value.trim() === "") {
        alert("Preencha o campo Número!");
        numero_fornecedor.focus();
        return false;
    }
    if(bairro_fornecedor.value.trim() === ""){
        alert("Preencha o campo Bairro!");
        bairro_fornecedor.focus();
        return false;
    }
    if(cidade_fornecedor.value.trim() === "") {
        alert("Preencha o campo Cidade!");
        cidade_fornecedor.focus();
        return false;
    }
    if(!uf_fornecedor.value) {
        alert("Selecione o Estado (UF)!");
        uf_fornecedor.focus();
        return false;
    }

    return true;  

}

