let responsavel = document.getElementById("responsavel");
let razao_social = document.getElementById("razao_social");
let cnpj_fornecedor = document.getElementById("cnpj_fornecedor");
let telefone_fornecedor = document.getElementById("telefone_fornecedor");
let email_fornecedor = document.getElementById("email_fornecedor");
let cep_fornecedor = document.getElementById("cep_fornecedor");
let rua_fornecedor = document.getElementById("rua_fornecedor");
let numero_fornecedor = document.getElementById("numero_fornecedor");
let bairro_fornecedor = document.getElementById("bairro_fornecedor");
let cidade_fornecedor = document.getElementById("cidade_fornecedor");
let uf_fornecedor = document.getElementById("uf_fornecedor");

function ValidacaoFornecedor(event) {
   
    //============ Validação para campos vazios ============ 
    

    if(razao_social.value.trim() === "") {
        alert("Preencha o campo da razão social!");
        razao_social.focus();
        return false;
    }
    if(cnpj_fornecedor.value.trim() === "") {
        alert("Preencha o campo CNPJ!");
        cnpj_fornecedor.focus();
        return false;
    };
    
    if(telefone_fornecedor.value.trim() === "") {
        alert("Preencha o campo Telefone!");
        telefone_fornecedor.focus();
        return false;
    }
    
    if(email_fornecedor.value.trim() === "") {
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

