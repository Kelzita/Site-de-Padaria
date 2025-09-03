 // Função para aplicar máscaras nos campos
 function aplicarMascaras() {
    // Máscara para CPF
    const cpfInput = document.getElementById('cpf_funcionario');
    cpfInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);
        
        if (value.length <= 11) {
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }
        
        e.target.value = value;
    });

    // Máscara para telefone
    const telefoneInput = document.getElementById('telefone_funcionario');
    telefoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > 11) value = value.slice(0, 11);
        
        if (value.length <= 11) {
            if (value.length <= 2) {
                value = value.replace(/(\d{0,2})/, '($1');
            } else if (value.length <= 6) {
                value = value.replace(/(\d{2})(\d{0,4})/, '($1) $2');
            } else if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else {
                value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            }
        }
        
        e.target.value = value;
    });

    // Máscara para CEP
    const cepInput = document.getElementById('cep_funcionario');
    cepInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 8) value = value.slice(0, 8);
        
        if (value.length > 5) {
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
        }
        
        e.target.value = value;
    });
}

// Função para buscar CEP
function configurarBuscaCep() {
    const buscarCepBtn = document.getElementById('buscar-cep');
    const cepInput = document.getElementById('cep_funcionario');
    const carregandoCep = document.getElementById('carregando-cep');
    
    buscarCepBtn.addEventListener('click', buscarCep);
    cepInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscarCep();
        }
    });
    
    function buscarCep() {
        const cep = cepInput.value.replace(/\D/g, '');
        
        if (cep.length !== 8) {
            alert('Por favor, digite um CEP válido com 8 dígitos.');
            return;
        }
        
        // Mostrar ícone de carregamento
        buscarCepBtn.style.display = 'none';
        carregandoCep.style.display = 'block';
        
        // Fazer a requisição para a API ViaCEP
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    alert('CEP não encontrado. Por favor, verifique o número digitado.');
                } else {
                    // Preencher os campos com os dados retornados
                    document.getElementById('rua_funcionario').value = data.logradouro || '';
                    document.getElementById('bairro_funcionario').value = data.bairro || '';
                    document.getElementById('cidade_funcionario').value = data.localidade || '';
                    document.getElementById('uf_funcionario').value = data.uf || '';
                    
                    // Dar foco no campo número
                    document.getElementById('numero_funcionario').focus();
                }
            })
            .catch(error => {
                console.error('Erro ao buscar CEP:', error);
                alert('Erro ao buscar CEP. Por favor, tente novamente.');
            })
            .finally(() => {
                // Esconder ícone de carregamento e mostrar ícone de busca novamente
                carregandoCep.style.display = 'none';
                buscarCepBtn.style.display = 'block';
            });
    }
}

// Visualização da foto selecionada
document.getElementById('foto_funcionario').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('foto_funcionario_preview').src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Fechar modal ao clicar no X
document.querySelector('.modal-editar__fechar').addEventListener('click', function() {
    document.querySelector('.modal-editar').style.display = 'none';
});

// Cancelar edição
document.querySelector('.botao--secundario').addEventListener('click', function() {
    document.querySelector('.modal-editar').style.display = 'none';
});

// Inicializar quando o documento estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    aplicarMascaras();
    configurarBuscaCep();
});