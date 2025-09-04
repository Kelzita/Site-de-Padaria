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


// ===== Buscar CEP funcionar=====
async function buscarCEP(cep){
    cep = cep.replace(/\D/g,'');
    if(cep.length !== 8){ 
        alert("CEP inválido!"); 
        return null; 
    }

    if(localStorage.getItem(`cep_${cep}`)){
        return JSON.parse(localStorage.getItem(`cep_${cep}`));
    }

    try {
        let response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        let data = await response.json();
        if(data.erro){ 
            alert("CEP não encontrado!"); 
            return null; 
        }
        localStorage.setItem(`cep_${cep}`, JSON.stringify(data));
        return data;
    } catch(e){ 
        alert("Erro ao buscar o CEP!"); 
        return null; 
    }
}

// ===== Preencher campos =====
function preencherEndereco(prefixo, data){
    $(`#rua_${prefixo}`).val(data.logradouro || '');
    $(`#bairro_${prefixo}`).val(data.bairro || '');
    $(`#cidade_${prefixo}`).val(data.localidade || '');
    $(`#uf_${prefixo}`).val(data.uf || '');
}

// ===== CEP Funcionário =====
async function buscarCEPFuncionario(){
    let cep = $("#cep_funcionario").val();
    
    // Mostrar loading
    const lupaIcon = document.querySelector("#cep_funcionario + .busca_lupa");
    const originalClass = lupaIcon.className;
    lupaIcon.className = "ri-loader-4-line busca_lupa animar";
    
    try {
        let data = await buscarCEP(cep);
        
        if(data){ 
            preencherEndereco('funcionario', data); 
        }
    } catch(error) {
        console.error("Erro na busca de CEP:", error);
        alert("Ocorreu um erro ao buscar o CEP. Tente novamente.");
    } finally {
        // Restaurar ícone original (executa sempre, mesmo em caso de erro)
        lupaIcon.className = originalClass;
    }
}
// ===== Máscara CEP =====
function aplicarMascaraCEP(cep) {
    cep = cep.replace(/\D/g, '');
    if (cep.length > 5) {
        cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
    }
    return cep;
}

// ===== Formatar CEP durante a digitação =====
function formatCEP(input) {
    input.value = aplicarMascaraCEP(input.value);
}

// ===== Event Listeners para o CEP do funcionário =====
document.addEventListener('DOMContentLoaded', function() {
    const cepFuncionarioInput = document.getElementById('cep_funcionario');
    
    // Permitir busca de CEP ao pressionar Enter
    cepFuncionarioInput.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            buscarCEPFuncionario();
        }
    });
    
    // Aplicar máscara quando o campo perde o foco (caso o usuário cole um valor)
    cepFuncionarioInput.addEventListener("blur", function() {
        this.value = aplicarMascaraCEP(this.value);
    });
    
    // Aplicar máscara também durante a digitação (backup)
    cepFuncionarioInput.addEventListener("input", function() {
        this.value = aplicarMascaraCEP(this.value);
    });
    
    // Adicionar animação de rotação
    const style = document.createElement('style');
    style.textContent = `
         @keyframes spin {
            0% { transform: rotate(0deg); }
             100% { transform: rotate(360deg); }
            }
        .animar {
         animation: spin 1s linear infinite;
         top: 12px;
       
        }
    `;
    document.head.appendChild(style);
});




// ===== Buscar CEP FORNECEDOR =====
async function buscarCEP(cep){
    cep = cep.replace(/\D/g,'');
    if(cep.length !== 8){ 
        mostrarNotificacao("CEP inválido! Deve conter 8 dígitos.", "error");
        return null; 
    }

    if(localStorage.getItem(`cep_${cep}`)){
        return JSON.parse(localStorage.getItem(`cep_${cep}`));
    }

    try {
        let response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        let data = await response.json();
        if(data.erro){ 
            mostrarNotificacao("CEP não encontrado!", "error"); 
            return null; 
        }
        localStorage.setItem(`cep_${cep}`, JSON.stringify(data));
        return data;
    } catch(e){ 
        mostrarNotificacao("Erro ao buscar o CEP!", "error"); 
        return null; 
    }
}

// ===== Preencher campos =====
function preencherEndereco(prefixo, data){
    document.getElementById(`rua_${prefixo}`).value = data.logradouro || '';
    document.getElementById(`bairro_${prefixo}`).value = data.bairro || '';
    document.getElementById(`cidade_${prefixo}`).value = data.localidade || '';
    document.getElementById(`uf_${prefixo}`).value = data.uf || '';
}

// ===== CEP Fornecedor =====
async function buscarCEPFornecedor(){
    const cepInput = document.getElementById("cep_fornecedor");
    let cep = cepInput.value;
    
    // Mostrar loading
    const lupaIcon = document.querySelector("#cep_fornecedor + .busca_lupa");
    const originalClass = lupaIcon.className;
    lupaIcon.className = "ri-loader-4-line busca_lupa animar";
    
    try {
        let data = await buscarCEP(cep);
        
        if(data){ 
            preencherEndereco('fornecedor', data);
            mostrarNotificacao("Endereço preenchido com sucesso!", "success");
        }
    } catch(error) {
        console.error("Erro na busca de CEP:", error);
        mostrarNotificacao("Ocorreu um erro ao buscar o CEP. Tente novamente.", "error");
    } finally {
        // Restaurar ícone original (executa sempre, mesmo em caso de erro)
        lupaIcon.className = originalClass;
    }
}

// ===== Máscara CEP =====
function aplicarMascaraCEP(cep) {
    cep = cep.replace(/\D/g, '');
    if (cep.length > 5) {
        cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
    }
    return cep;
}

// ===== Formatar CEP durante a digitação =====
function formatCEP(input) {
    input.value = aplicarMascaraCEP(input.value);
}

// ===== Mostrar notificação =====
function mostrarNotificacao(mensagem, tipo) {
    const notification = document.getElementById("notification");
    notification.textContent = mensagem;
    notification.className = "notification " + tipo;
    notification.style.display = "block";
    
    // Esconder a notificação após 5 segundos
    setTimeout(() => {
        notification.style.display = "none";
    }, 5000);
}

// ===== Validar formulário =====
function validarFormulario() {
    const cep = document.getElementById("cep_fornecedor").value;
    const razaoSocial = document.getElementById("razao_social").value;
    
    if (!razaoSocial) {
        mostrarNotificacao("Por favor, preencha a Razão Social!", "error");
        return;
    }
    
    if (cep.replace(/\D/g, '').length !== 8) {
        mostrarNotificacao("Por favor, insira um CEP válido!", "error");
        return;
    }
    
    mostrarNotificacao("Fornecedor cadastrado com sucesso!", "success");
}

// ===== Event Listeners para o CEP do fornecedor =====
document.addEventListener('DOMContentLoaded', function() {
    const cepFornecedorInput = document.getElementById('cep_fornecedor');
    
    // Permitir busca de CEP ao pressionar Enter
    cepFornecedorInput.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            buscarCEPFornecedor();
        }
    });
    
    // Aplicar máscara quando o campo perde o foco (caso o usuário cole um valor)
    cepFornecedorInput.addEventListener("blur", function() {
        this.value = aplicarMascaraCEP(this.value);
    });
    
    // Aplicar máscara também durante a digitação (backup)
    cepFornecedorInput.addEventListener("input", function() {
        this.value = aplicarMascaraCEP(this.value);
    });
    
    // Adicionar animação de rotação
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animar {
             animation: spin 1s linear infinite;
            top: 12px;
 
        }
    `;
    document.head.appendChild(style);
});
