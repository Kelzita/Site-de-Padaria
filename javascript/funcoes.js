$(document).ready(function(){

    // ===== Máscaras =====
    Inputmask({"mask": "(99) 99999-9999", "placeholder": "", showMaskOnHover: false, showMaskOnFocus: false})
        .mask("#telefone_funcionario, #telefone_fornecedor");

    Inputmask({"mask": "999.999.999-99", "placeholder": "", showMaskOnHover: false, showMaskOnFocus: false})
        .mask("#cpf_funcionario");

    Inputmask({"mask": "99.999.999/9999-99", "placeholder": "", showMaskOnHover: false, showMaskOnFocus: false})
        .mask("#cnpj_fornecedor");

    Inputmask({"mask": "99999-999", "placeholder": "", showMaskOnHover: false, showMaskOnFocus: false})
        .mask("#cep_funcionario, #cep_fornecedor");

    // ===== Limite data =====
    const today = new Date().toISOString().split('T')[0];
    $('#data_admissao').attr('max', today);
});

// ===== Toggle senha =====
function toggleSenha() {
    const inputSenha = $("#senha");
    const botao = $("#login-eye");

    if(inputSenha.attr('type') === "password"){
        inputSenha.attr('type','text');
        botao.removeClass("ri-eye-off-line").addClass("ri-eye-line");
    } else {
        inputSenha.attr('type','password');
        botao.removeClass("ri-eye-line").addClass("ri-eye-off-line");
    }
}

// ===== Buscar CEP =====
async function buscarCEP(cep){
    cep = cep.replace(/\D/g,'');
    if(cep.length !== 8){ alert("CEP inválido!"); return null; }

    if(localStorage.getItem(`cep_${cep}`)){
        return JSON.parse(localStorage.getItem(`cep_${cep}`));
    }

    try {
        let response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        let data = await response.json();
        if(data.erro){ alert("CEP não encontrado!"); return null; }
        localStorage.setItem(`cep_${cep}`, JSON.stringify(data));
        return data;
    } catch(e){ alert("Erro ao buscar o CEP!"); return null; }
}

// ===== Preencher campos =====
function preencherEndereco(prefixo, data){
    $(`#rua_${prefixo}`).val(data.logradouro || '');
    $(`#bairro_${prefixo}`).val(data.bairro || '');
    $(`#cidade_${prefixo}`).val(data.localidade || '');
    $(`#uf_${prefixo}`).val(data.uf || '');
}

// ===== CEP Fornecedor =====
async function buscarCEPFornecedor(){
    let cep = $("#cep_fornecedor").val();
    let data = await buscarCEP(cep);
    if(data){ preencherEndereco('fornecedor', data); }
}

// ===== CEP Funcionário =====
async function buscarCEPFuncionario(){
    let cep = $("#cep_funcionario").val();
    let data = await buscarCEP(cep);
    if(data){ preencherEndereco('funcionario', data); }
}
