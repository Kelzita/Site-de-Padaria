<?php 
require_once 'funcoes.php';
require_once 'buscar_funcionario.php';
?>

<!-- MODAL DE VISUALIZAR FORNECEDOR -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="fecharModal">&times;</span>
        <h3>Detalhes do Fornecedor</h3>
        <div class="modal-body">
            <p><b>ID: </b> <span id="modal-id"></span></p>
            <p><b>Razão Social: </b> <span id="modal-razao_social"></span></p>
            <p><b>Responsável: </b> <span id="modal-responsavel"></span></p>
            <p><b>CNPJ: </b> <span id="modal-cnpj_fornecedor"></span></p>
            <p><b>E-mail: </b> <span id="modal-email_fornecedor"></span></p>
            <p><b>Telefone: </b> <span id="modal-telefone_fornecedor"></span></p>
            <p><b>CEP: </b> <span id="modal-cep_fornecedor"></span></p>
            <p><b>Rua: </b> <span id="modal-rua_fornecedor"></span></p>
            <p><b>Número: </b> <span id="modal-numero_fornecedor"></span></p>
            <p><b>Bairro: </b> <span id="modal-bairro_fornecedor"></span></p>
            <p><b>Cidade: </b> <span id="modal-cidade_fornecedor"></span></p>
            <p><b>UF: </b> <span id="modal-uf_fornecedor"></span></p>
        </div>
        <div class="modal-footer">
            <a id="btn-alterar" href="#" class="btn-alterar"><i class="ri-edit-line"></i></a>
        </div>
    </div>
</div>

<!-- MODAL ALTERAR -->
<div id="modalEditar" class="modalEditar">
    <div class="container">
        <span class="fecharModal">&times;</span>
        <h2>Alterar Fornecedor</h2>
        <form id="form-alterar" action="../php/alterar_fornecedor.php" method="POST">
            <input type="hidden" name="id_fornecedor" id="alterar-id">

            <label>Razão Social:</label>
            <input type="text" name="razao_social" id="alterar-razao_social">

            <label>Responsável:</label>
            <input type="text" name="responsavel" id="alterar-responsavel">

            <label>CNPJ:</label>
            <input type="text" name="cnpj_fornecedor" id="alterar-cnpj_fornecedor" maxlength="18">

            <label>E-mail:</label>
            <input type="email" name="email_fornecedor" id="alterar-email_fornecedor">

            <label>Telefone:</label>
            <input type="text" name="telefone_fornecedor" id="alterar-telefone-fornecedor" maxlength="15">

            <label>CEP:</label>
            <div class="input-container-cep">
                <input type="text" name="cep_fornecedor" id="alterar-cep_fornecedor" maxlength="9" placeholder="Digite o CEP (ex: 00000-000)">
                <i class="ri-search-line busca_lupa" onclick="buscarCEPFornecedor()"></i>
            </div>

            <label>Rua:</label>
            <input type="text" name="rua_fornecedor" id="alterar-rua_fornecedor">

            <label>Número:</label>
            <input type="text" name="numero_fornecedor" id="alterar-numero_fornecedor">

            <label>Bairro:</label>
            <input type="text" name="bairro_fornecedor" id="alterar-bairro_fornecedor">

            <label>Cidade:</label>
            <input type="text" name="cidade_fornecedor" id="alterar-cidade_fornecedor">

            <label>UF:</label>
            <select name="uf_fornecedor" id="alterar-uf_fornecedor">
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>

            <button type="submit" class="btn-salvar">Salvar Alterações</button>
        </form>
    </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal");
    const modalAlterar = document.getElementById("modalEditar");
    const fecharBtns = document.querySelectorAll(".fechar");
    const btnAlterar = document.getElementById("btn-alterar");

    // Função para abrir modal de visualização
    document.querySelectorAll(".visualizar").forEach(botao => {
        botao.addEventListener("click", e => {
            e.preventDefault();

            // Preenche dados
            document.getElementById("modal-id").textContent = botao.dataset.id;
            document.getElementById("modal-razao_social").textContent = botao.dataset.razao_social;
            document.getElementById("modal-responsavel").textContent = botao.dataset.responsavel;
            document.getElementById("modal-cnpj_fornecedor").textContent = botao.dataset.cnpj_fornecedor;
            document.getElementById("modal-email_fornecedor").textContent = botao.dataset.email_fornecedor;
            document.getElementById("modal-telefone_fornecedor").textContent = botao.dataset.telefone_fornecedor;
            document.getElementById("modal-cep_fornecedor").textContent = botao.dataset.cep_fornecedor;
            document.getElementById("modal-rua_fornecedor").textContent = botao.dataset.rua_fornecedor;
            document.getElementById("modal-numero_fornecedor").textContent = botao.dataset.numero_fornecedor;
            document.getElementById("modal-bairro_fornecedor").textContent = botao.dataset.bairro_fornecedor;
            document.getElementById("modal-cidade_fornecedor").textContent = botao.dataset.cidade_fornecedor;
            document.getElementById("modal-uf_fornecedor").textContent = botao.dataset.uf_fornecedor;

            modal.style.display = "flex";
        });
    });

    // Configurar botão de alterar dentro do modal de visualização
    btnAlterar.addEventListener("click", (e) => {
        e.preventDefault();
        
        // Preenche modal de alteração com os dados do modal de visualização
        document.getElementById("alterar-id").value = document.getElementById("modal-id").textContent;
        document.getElementById("alterar-razao_social").value = document.getElementById("modal-razao_social").textContent;
        document.getElementById("alterar-responsavel").value = document.getElementById("modal-responsavel").textContent;
        document.getElementById("alterar-cnpj_fornecedor").value = document.getElementById("modal-cnpj_fornecedor").textContent;
        document.getElementById("alterar-email_fornecedor").value = document.getElementById("modal-email_fornecedor").textContent;
        document.getElementById("alterar-telefone-fornecedor").value = document.getElementById("modal-telefone_fornecedor").textContent;
        document.getElementById("alterar-cep_fornecedor").value = document.getElementById("modal-cep_fornecedor").textContent;
        document.getElementById("alterar-rua_fornecedor").value = document.getElementById("modal-rua_fornecedor").textContent;
        document.getElementById("alterar-numero_fornecedor").value = document.getElementById("modal-numero_fornecedor").textContent;
        document.getElementById("alterar-bairro_fornecedor").value = document.getElementById("modal-bairro_fornecedor").textContent;
        document.getElementById("alterar-cidade_fornecedor").value = document.getElementById("modal-cidade_fornecedor").textContent;
        document.getElementById("alterar-uf_fornecedor").value = document.getElementById("modal-uf_fornecedor").textContent;

        // Fecha modal de visualização
        modal.style.display = "none";

        // Abre modal de alteração
        modalAlterar.style.display = "flex";
    });

    // Função para abrir modal de alteração diretamente
    document.querySelectorAll(".alterar").forEach(botao => {
        botao.addEventListener("click", e => {
            e.preventDefault();

            // Preenche modal de alteração
            document.getElementById("alterar-id").value = botao.dataset.id;
            document.getElementById("alterar-razao_social").value = botao.dataset.razao_social;
            document.getElementById("alterar-responsavel").value = botao.dataset.responsavel;
            
            // Aplica máscaras aos valores ao preencher o modal
            cnpjInput.value = aplicarMascaraCNPJ(botao.dataset.cnpj_fornecedor || '');
            document.getElementById("alterar-email_fornecedor").value = botao.dataset.email_fornecedor;
            telefoneInput.value = aplicarMascaraTelefone(botao.dataset.telefone_fornecedor || '');
            cepInput.value = aplicarMascaraCEP(botao.dataset.cep_fornecedor || '');
            
            document.getElementById("alterar-rua_fornecedor").value = botao.dataset.rua_fornecedor;
            document.getElementById("alterar-numero_fornecedor").value = botao.dataset.numero_fornecedor;
            document.getElementById("alterar-bairro_fornecedor").value = botao.dataset.bairro_fornecedor;
            document.getElementById("alterar-cidade_fornecedor").value = botao.dataset.cidade_fornecedor;
            document.getElementById("alterar-uf_fornecedor").value = botao.dataset.uf_fornecedor;

            // Abre modal
            modalAlterar.style.display = "flex";
        });
    });

    // Fechar modais
    fecharBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            modal.style.display = "none";
            modalAlterar.style.display = "none";
        });
    });

    window.addEventListener("click", e => {
        if (e.target === modal) modal.style.display = "none";
        if (e.target === modalAlterar) modalAlterar.style.display = "none";
    });

    // Funções para aplicar máscaras
    function aplicarMascaraCNPJ(cnpj) {
        cnpj = cnpj.replace(/\D/g, '');
        cnpj = cnpj.replace(/^(\d{2})(\d)/, '$1.$2');
        cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        cnpj = cnpj.replace(/\.(\d{3})(\d)/, '.$1/$2');
        cnpj = cnpj.replace(/(\d{4})(\d)/, '$1-$2');
        return cnpj.substring(0, 18);
    }

    function aplicarMascaraTelefone(telefone) {
        telefone = telefone.replace(/\D/g, '');
        
        // Verifica se é celular (com 9º dígito) ou telefone fixo
        if (telefone.length === 11) {
            telefone = telefone.replace(/^(\d{2})(\d)/, '($1) $2');
            telefone = telefone.replace(/(\d{5})(\d{4})/, '$1-$2');
        } else if (telefone.length === 10) {
            telefone = telefone.replace(/^(\d{2})(\d)/, '($1) $2');
            telefone = telefone.replace(/(\d{4})(\d{4})/, '$1-$2');
        } else if (telefone.length > 0) {
            telefone = telefone.replace(/^(\d{0,2})/, '($1');
            telefone = telefone.replace(/^\((\d{2})(\d)/, '($1) $2');
            if (telefone.length > 10) {
                telefone = telefone.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                telefone = telefone.replace(/(\d{4})(\d)/, '$1-$2');
            }
        }
        
        return telefone.substring(0, 15);
    }

    function aplicarMascaraCEP(cep) {
        cep = cep.replace(/\D/g, '');
        cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
        return cep.substring(0, 9);
    }

    // Elementos que receberão máscaras
    const cnpjInput = document.getElementById("alterar-cnpj_fornecedor");
    const telefoneInput = document.getElementById("alterar-telefone-fornecedor");
    const cepInput = document.getElementById("alterar-cep_fornecedor");
    
    // Aplicar máscaras na digitação
    if (cnpjInput) {
        cnpjInput.addEventListener("input", function() {
            this.value = aplicarMascaraCNPJ(this.value);
        });
        
        cnpjInput.addEventListener("blur", function() {
            this.value = aplicarMascaraCNPJ(this.value);
        });
    }
    
    if (telefoneInput) {
        telefoneInput.addEventListener("input", function() {
            this.value = aplicarMascaraTelefone(this.value);
        });
        
        telefoneInput.addEventListener("blur", function() {
            this.value = aplicarMascaraTelefone(this.value);
        });
    }
    
    if (cepInput) {
        cepInput.addEventListener("input", function() {
            this.value = aplicarMascaraCEP(this.value);
        });
        
        cepInput.addEventListener("blur", function() {
            this.value = aplicarMascaraCEP(this.value);
        });
    }
});

// Função para buscar CEP
function buscarCEPFornecedor() {
    const cepInput = document.getElementById("alterar-cep_fornecedor");
    const cep = cepInput.value.replace(/\D/g, '');
    
    if (cep.length !== 8) {
        alert("Por favor, digite um CEP válido com 8 dígitos.");
        return;
    }
    
    // Exibir indicador de carregamento
    const lupaIcon = document.querySelector(".busca_lupa");
    const originalClass = lupaIcon.className;
    lupaIcon.className = "ri-loader-4-line busca_lupa animar";
    
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                alert("CEP não encontrado. Por favor, verifique o número digitado.");
            } else {
                // Preencher os campos com os dados do CEP
                document.getElementById("alterar-rua_fornecedor").value = data.logradouro || '';
                document.getElementById("alterar-bairro_fornecedor").value = data.bairro || '';
                document.getElementById("alterar-cidade_fornecedor").value = data.localidade || '';
                document.getElementById("alterar-uf_fornecedor").value = data.uf || '';
                
                // Dar foco no campo número após preencher os dados
                document.getElementById("alterar-numero_fornecedor").focus();
            }
            
            // Restaurar ícone original
            lupaIcon.className = originalClass;
        })
        .catch(error => {
            console.error("Erro ao buscar CEP:", error);
            alert("Erro ao buscar CEP. Por favor, tente novamente.");
            
            // Restaurar ícone original
            lupaIcon.className = originalClass;
        });
}

// Permitir busca de CEP ao pressionar Enter
document.getElementById("alterar-cep_fornecedor").addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        buscarCEPFornecedor();
    }
});
</script>

<style>
/* Estilos para os modais */
.modal, .modalEditar {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.modal-content, .modalEditar .container {
    background-color: #fefefe;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 600px;
    position: relative;
}

.fechar {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    position: absolute;
    right: 15px;
    top: 10px;
}

.fechar:hover,
.fechar:focus {
    color: black;
    text-decoration: none;
}

.modal-body p {
    margin: 10px 0;
}



.input-container-cep {
    position: relative;
    display: flex;
    align-items: center;
}

.busca_lupa {
    position: absolute;
    right: 10px;
    cursor: pointer;
    font-size: 18px;
}

.animar {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.btn-salvar {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 15px;
}

.btn-salvar:hover {
    background-color: #45a049;
}
</style>