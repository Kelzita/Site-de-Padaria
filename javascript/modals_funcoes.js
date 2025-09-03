// FUNÇÕES PARA O FUNCIONARIOS
// Funções para aplicar máscaras
function aplicarMascaraCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    return cpf.substring(0, 14);
}

function aplicarMascaraTelefone(telefone) {
    telefone = telefone.replace(/\D/g, '');
    
    if (telefone.length === 11) {
        telefone = telefone.replace(/^(\d{2})(\d)/, '($1) $2');
        telefone = telefone.replace(/(\d{5})(\d{4})/, '$1-$2');
    } else if (telefone.length === 10) {
        telefone = telefone.replace(/^(\d{2})(\d)/, '($1) $2');
        telefone = telefone.replace(/(\d{4})(\d{4})/, '$1-$2');
    }
    
    return telefone.substring(0, 15);
}

function aplicarMascaraCEP(cep) {
    cep = cep.replace(/\D/g, '');
    cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
    return cep.substring(0, 9);
}

// Função para buscar CEP
function buscarCEPFuncionario() {
    const cepInput = document.getElementById("alterar-cep_funcionario");
    const cep = cepInput.value.replace(/\D/g, '');
    
    if (cep.length !== 8) {
        alert("Por favor, digite um CEP válido com 8 dígitos.");
        return;
    }
    
    const lupaIcon = document.querySelector("#modalEditarFuncionario .busca_lupa");
    const originalClass = lupaIcon.className;
    lupaIcon.className = "ri-loader-4-line busca_lupa animar";
    
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                alert("CEP não encontrado.");
            } else {
                document.getElementById("alterar-rua_funcionario").value = data.logradouro || '';
                document.getElementById("alterar-bairro_funcionario").value = data.bairro || '';
                document.getElementById("alterar-cidade_funcionario").value = data.localidade || '';
                document.getElementById("alterar-uf_funcionario").value = data.uf || '';
                document.getElementById("alterar-numero_funcionario").focus();
            }
            lupaIcon.className = originalClass;
        })
        .catch(error => {
            console.error("Erro ao buscar CEP:", error);
            alert("Erro ao buscar CEP. Por favor, tente novamente.");
            lupaIcon.className = originalClass;
        });
}

// Setup do preview da foto
function setupFotoPreview() {
    const fotoInput = document.getElementById("alterar-foto_funcionario");
    if (fotoInput) {
        fotoInput.addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    alert('Por favor, selecione apenas arquivos de imagem.');
                    this.value = '';
                    return;
                }
                
                if (file.size > 2 * 1024 * 1024) {
                    alert('A imagem deve ter no máximo 2MB.');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("alterar-foto-preview").src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
}

// Inicialização quando o DOM estiver carregado
document.addEventListener("DOMContentLoaded", () => {
    // Configurar máscaras e eventos
    const cpfInput = document.getElementById("alterar-cpf_funcionario");
    const telefoneInput = document.getElementById("alterar-telefone_funcionario");
    const cepInput = document.getElementById("alterar-cep_funcionario");
    
    setupFotoPreview();
    
    // Aplicar máscaras
    [cpfInput, telefoneInput, cepInput].forEach(input => {
        if (input) {
            const maskFunction = input === cpfInput ? aplicarMascaraCPF : 
                                input === telefoneInput ? aplicarMascaraTelefone : 
                                aplicarMascaraCEP;
            
            input.addEventListener("input", function() {
                this.value = maskFunction(this.value);
            });
            
            input.addEventListener("blur", function() {
                this.value = maskFunction(this.value);
            });
        }
    });
    
    // Evento para busca de CEP com Enter
    if (cepInput) {
        cepInput.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                buscarCEPFuncionario();
            }
        });
    }

    // Event listeners para os botões de visualizar e alterar
    document.addEventListener('click', function(e) {
        // Visualizar funcionário
        const botaoVisualizar = e.target.closest('.visualizarfuncionario');
        if (botaoVisualizar) {
            e.preventDefault();
            preencherModalFuncionario(botaoVisualizar.dataset);
            document.getElementById("modalFuncionario").style.display = "flex";
        }
        
        // Alterar funcionário
        const botaoAlterar = e.target.closest('.alterarfuncionario');
        if (botaoAlterar) {
            e.preventDefault();
            preencherModalEditarFuncionario(botaoAlterar.dataset);
            document.getElementById("modalEditarFuncionario").style.display = "flex";
        }
        
        // Fechar modais
        if (e.target.classList.contains('fechar') || e.target.classList.contains('modal') || e.target.classList.contains('modalEditar')) {
            document.querySelectorAll('.modal, .modalEditar').forEach(modal => {
                modal.style.display = "none";
            });
        }
    });

    // Botão de alterar no modal de visualização
    const btnAlterar = document.getElementById("btn-alterar-funcionario");
    if (btnAlterar) {
        btnAlterar.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById("modalFuncionario").style.display = "none";
            document.getElementById("modalEditarFuncionario").style.display = "flex";
        });
    }
});

// Função para preencher modal de visualização
function preencherModalFuncionario(dados) {
    const campos = {
        'modal-foto': {prop: 'src', valor: dados.foto || "../img/avatars/default_avatar.png"},
        'modal-id_funcionario': {prop: 'textContent', valor: dados.id_funcionario || ''},
        'modal-nome_funcionario': {prop: 'textContent', valor: dados.nome_funcionario || ''},
        'modal-cpf_funcionario': {prop: 'textContent', valor: dados.cpf_funcionario || ''},
        'modal-senha': {prop: 'textContent', valor: dados.senha || ''},
        'modal-email_funcionario': {prop: 'textContent', valor: dados.email_funcionario || ''},
        'modal-telefone_funcionario': {prop: 'textContent', valor: dados.telefone_funcionario || ''},
        'modal-cep_funcionario': {prop: 'textContent', valor: dados.cep_funcionario || ''},
        'modal-rua_funcionario': {prop: 'textContent', valor: dados.rua_funcionario || ''},
        'modal-numero_funcionario': {prop: 'textContent', valor: dados.numero_funcionario || ''},
        'modal-bairro_funcionario': {prop: 'textContent', valor: dados.bairro_funcionario || ''},
        'modal-cidade_funcionario': {prop: 'textContent', valor: dados.cidade_funcionario || ''},
        'modal-uf_funcionario': {prop: 'textContent', valor: dados.uf_funcionario || ''},
        'modal-data_admissao': {prop: 'textContent', valor: dados.data_admissao || ''},
        'modal-salario': {prop: 'textContent', valor: dados.salario ? 'R$ ' + parseFloat(dados.salario).toFixed(2) : ''},
        'modal-id_funcao': {prop: 'textContent', valor: dados.id_funcao || ''}
    };

    Object.entries(campos).forEach(([id, config]) => {
        const element = document.getElementById(id);
        if (element) element[config.prop] = config.valor;
    });
}

// Função para preencher modal de edição
function preencherModalEditarFuncionario(dados) {
    const modalAlterar = document.getElementById("modalEditarFuncionario");
    if (!modalAlterar) return;
    
    document.getElementById("alterar-id_funcionario").value = dados.id_funcionario || '';
    document.getElementById("alterar-nome_funcionario").value = dados.nome_funcionario || '';
    document.getElementById("alterar-cpf_funcionario").value = aplicarMascaraCPF(dados.cpf_funcionario || '');
    document.getElementById("alterar-email_funcionario").value = dados.email_funcionario || '';
    document.getElementById("alterar-telefone_funcionario").value = aplicarMascaraTelefone(dados.telefone_funcionario || '');
    document.getElementById("alterar-data_admissao").value = dados.data_admissao || '';
    document.getElementById("alterar-salario").value = dados.salario || '';
    document.getElementById("alterar-id_funcao").value = dados.id_funcao || '';
    document.getElementById("alterar-cep_funcionario").value = aplicarMascaraCEP(dados.cep_funcionario || '');
    document.getElementById("alterar-rua_funcionario").value = dados.rua_funcionario || '';
    document.getElementById("alterar-numero_funcionario").value = dados.numero_funcionario || '';
    document.getElementById("alterar-bairro_funcionario").value = dados.bairro_funcionario || '';
    document.getElementById("alterar-cidade_funcionario").value = dados.cidade_funcionario || '';
    document.getElementById("alterar-uf_funcionario").value = dados.uf_funcionario || '';
    
    // Preview da foto
    if (dados.foto) {
        document.getElementById("alterar-foto-preview").src = dados.foto;
        document.getElementById("foto_atual").value = dados.foto;
    }
    
    // Campo de senha (deixa em branco por segurança)
    document.getElementById("alterar-senha").value = '';
}


//FUNCOES PARA OS FORNECEDORES

