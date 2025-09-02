<?php 
require_once 'funcoes.php';
require_once 'buscar_funcionario.php';

?>


<!-- MODAL DE VISUALIZAR FORNECEDOR -->
 
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="fechar">&times;</span>
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
<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal");
    const fecharBtns = modal.querySelectorAll(".fechar, .btn-fechar");
    const btnAlterar = document.getElementById("btn-alterar");

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

            btnAlterar.addEventListener("click", () => {
            const modalAlterar = document.getElementById("modalEditar");

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
            modal.style.display = "flex";
        });
    });

    // Fechar modal
    fecharBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            modal.style.display = "none";
        });
    });

    window.addEventListener("click", e => {
        if (e.target === modal) modal.style.display = "none";
    });
});
</script>



<!-- =======================================================================================================================================-->



<!-- MODAL ALTERAR -->
<div id="modalEditar" class="modalEditar">
    <div class="container">
        <span id="fecharModal">&times;</span>
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

// Aplicar máscaras quando o modal for aberto
document.addEventListener("DOMContentLoaded", () => {
    const modalAlterar = document.getElementById("modalEditar");
    const fecharAlterar = document.getElementById("fecharModal");
    
    // Elementos que receberão máscaras
    const cnpjInput = document.getElementById("alterar-cnpj_fornecedor");
    const telefoneInput = document.getElementById("alterar-telefone-fornecedor");
    const cepInput = document.getElementById("alterar-cep_fornecedor");
    
    // Aplicar máscaras na digitação
    cnpjInput.addEventListener("input", function() {
        this.value = aplicarMascaraCNPJ(this.value);
    });
    
    telefoneInput.addEventListener("input", function() {
        this.value = aplicarMascaraTelefone(this.value);
    });
    
    cepInput.addEventListener("input", function() {
        this.value = aplicarMascaraCEP(this.value);
    });
    
    // Permitir busca de CEP ao pressionar Enter
    cepInput.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            buscarCEPFornecedor();
        }
    });
    
    // Aplicar máscaras quando o campo perde o foco (caso o usuário cole um valor)
    cnpjInput.addEventListener("blur", function() {
        this.value = aplicarMascaraCNPJ(this.value);
    });
    
    telefoneInput.addEventListener("blur", function() {
        this.value = aplicarMascaraTelefone(this.value);
    });
    
    cepInput.addEventListener("blur", function() {
        this.value = aplicarMascaraCEP(this.value);
    });

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

    // Fechar modal
    fecharAlterar.addEventListener("click", () => {
        modalAlterar.style.display = "none";
    });

    window.addEventListener("click", e => {
        if (e.target === modalAlterar) modalAlterar.style.display = "none";
    });
});
</script>

<script>
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

// Aplicar máscaras quando o modal for aberto
document.addEventListener("DOMContentLoaded", () => {
    const modalAlterar = document.getElementById("modalEditar");
    const fecharAlterar = document.getElementById("fecharModal");
    
    // Elementos que receberão máscaras
    const cnpjInput = document.getElementById("alterar-cnpj_fornecedor");
    const telefoneInput = document.getElementById("alterar-telefone-fornecedor");
    const cepInput = document.getElementById("alterar-cep_fornecedor");
    
    // Aplicar máscaras na digitação
    cnpjInput.addEventListener("input", function() {
        this.value = aplicarMascaraCNPJ(this.value);
    });
    
    telefoneInput.addEventListener("input", function() {
        this.value = aplicarMascaraTelefone(this.value);
    });
    
    cepInput.addEventListener("input", function() {
        this.value = aplicarMascaraCEP(this.value);
    });
    
    // Permitir busca de CEP ao pressionar Enter
    cepInput.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            buscarCEPFornecedor();
        }
    });
    
    // Aplicar máscaras quando o campo perde o foco (caso o usuário cole um valor)
    cnpjInput.addEventListener("blur", function() {
        this.value = aplicarMascaraCNPJ(this.value);
    });
    
    telefoneInput.addEventListener("blur", function() {
        this.value = aplicarMascaraTelefone(this.value);
    });
    
    cepInput.addEventListener("blur", function() {
        this.value = aplicarMascaraCEP(this.value);
    });

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

    // Fechar modal
    fecharAlterar.addEventListener("click", () => {
        modalAlterar.style.display = "none";
    });

    window.addEventListener("click", e => {
        if (e.target === modalAlterar) modalAlterar.style.display = "none";
    });
});
</script>



<!-- ========================= --> 
<div id="modalFuncionario" class="modal">
    <div class="modal-content">
        <span class="fechar">&times;</span>
        <h3>Detalhes do Funcionário</h3>
        <div class="modal-body">
            <p>
                <img id="modal-foto" src="" alt="Foto do Funcionário" style="width:120px; height:120px; object-fit:cover; border-radius:50%;">
            </p>
            <p><b>ID: </b> <span id="modal-id_funcionario"></span></p>
            <p><b>Nome: </b> <span id="modal-nome_funcionario"></span></p>
            <p><b>CPF: </b> <span id="modal-cpf_funcionario"></span></p>
            <p><b>Senha: </b> <span id="modal-senha"></span></p>
            <p><b>E-mail: </b> <span id="modal-email_funcionario"></span></p>
            <p><b>Telefone: </b> <span id="modal-telefone_funcionario"></span></p>
            <p><b>CEP: </b> <span id="modal-cep_funcionario"></span></p>
            <p><b>Rua: </b> <span id="modal-rua_funcionario"></span></p>
            <p><b>Número: </b> <span id="modal-numero_funcionario"></span></p>
            <p><b>Bairro: </b> <span id="modal-bairro_funcionario"></span></p>
            <p><b>Cidade: </b> <span id="modal-cidade_funcionario"></span></p>
            <p><b>UF: </b> <span id="modal-uf_funcionario"></span></p>
            <p><b>Data de Admissão: </b> <span id="modal-data_admissao"></span></p>
            <p><b>Salário: </b> <span id="modal-salario"></span></p>
            <p><b>Função: </b> <span id="modal-id_funcao"></span></p>
        </div>
        <div class="modal-footer">
            <a id="btn-alterar-funcionario" href="#" class="btn-alterar"><i class="ri-edit-line"></i></a>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalFuncionario");
    
    // Verifica se o modal existe antes de continuar
    if (!modal) {
        console.error("Modal funcionário não encontrado!");
        return;
    }

    const fecharBtns = modal.querySelectorAll(".fechar");
    const btnAlterar = document.getElementById("btn-alterar-funcionario");

    // Função para preencher os dados do modal
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
            // CAMPOS ADICIONAIS
            'modal-data_admissao': {prop: 'textContent', valor: dados.data_admissao || ''},
            'modal-salario': {prop: 'textContent', valor: dados.salario ? 'R$ ' + parseFloat(dados.salario).toFixed(2) : ''},
            'modal-id_funcao': {prop: 'textContent', valor: dados.id_funcao || ''}
        };

        // Preenche cada campo
        Object.entries(campos).forEach(([id, config]) => {
            const element = document.getElementById(id);
            if (element) {
                element[config.prop] = config.valor;
            } else {
                console.warn("Elemento não encontrado:", id);
            }
        });
    }

    // Event delegation para melhor performance
    document.addEventListener('click', function(e) {
        // Verifica se o clique foi em um botão de visualizar funcionário
        const botaoVisualizar = e.target.closest('.visualizarfuncionario');
        
        if (botaoVisualizar) {
            e.preventDefault();
            console.log("Dados do botão:", botaoVisualizar.dataset);
            
            // Preenche o modal com os dados do botão
            preencherModalFuncionario(botaoVisualizar.dataset);
            
            // Configura o botão de alterar
            if (btnAlterar) {
                btnAlterar.onclick = (event) => {
                    event.preventDefault();
                    const modalAlterar = document.getElementById("modalEditarFuncionario");
                    
                    if (modalAlterar) {
                        // Fecha modal de visualização e abre o de alteração
                        modal.style.display = "none";
                        modalAlterar.style.display = "flex";
                        
                        // Aqui você pode preencher o modal de edição também
                        // document.getElementById("alterar-id_funcionario").value = botaoVisualizar.dataset.id_funcionario;
                        // ... outros campos
                    }
                };
            }
            
            // Abre o modal
            modal.style.display = "flex";
        }
    });

    // Fechar modal
    fecharBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            modal.style.display = "none";
        });
    });

    // Fechar modal ao clicar fora
    window.addEventListener("click", e => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
</script>


<!-- MODAL ALTERAR FUNCIONÁRIO -->
<div id="modalEditarFuncionario" class="modalEditar">
    <div class="container">
        <span class="fechar">&times;</span>
        <h2>Alterar Funcionário</h2>
        <form id="form-alterar-funcionario" action="../php/alterar_funcionario.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_funcionario" id="alterar-id_funcionario">

            <label>Foto:</label>
            <div class="foto-container">
                <img id="alterar-foto-preview" src="../img/avatars/default_avatar.png" alt="Preview da Foto do Funcionário">
    
                 <input type="file" name="foto_funcionario" id="alterar-foto_funcionario" accept="image/*">
    
                <label for="alterar-foto_funcionario">
                 <i class="ri-camera-line"></i> Clique para alterar
                </label>
    
                <div class="foto-instructions">Formatos: JPG, PNG • Máx: 2MB</div>
    
            <input type="hidden" name="foto_atual" id="foto_atual">
        </div>


            <label>Nome:</label>
            <input type="text" name="nome_funcionario" id="alterar-nome_funcionario" required>

            <label>CPF:</label>
            <input type="text" name="cpf_funcionario" id="alterar-cpf_funcionario" maxlength="14" required>

            <label>Senha:</label>
            <input type="password" name="senha" id="alterar-senha" placeholder="Deixe em branco para manter a atual">
            
            <label>E-mail:</label>
            <input type="email" name="email_funcionario" id="alterar-email_funcionario" required>

            <label>Telefone:</label>
            <input type="text" name="telefone_funcionario" id="alterar-telefone_funcionario" maxlength="15">

            <label>Data de Admissão:</label>
            <input type="date" name="data_admissao" id="alterar-data_admissao">

            <label>Salário:</label>
            <input type="number" name="salario" id="alterar-salario" step="0.01" min="0">

            <label>Função:</label>
            <select name="id_funcao" id="alterar-id_funcao" required>
            <option selected disabled>Selecione a Função</option>
                <?php foreach ($funcoes as $funcao): ?>
                <option value="<?= htmlspecialchars($funcao['id_funcao']) ?>" <?=$funcao['id_funcao']==$idSelecionado ? 'selected' : '' ?>>
                <?= htmlspecialchars($funcao['id_funcao'] . ' - ' . $funcao['nome_funcao']) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label>CEP:</label>
            <div class="input-container-cep">
                <input type="text" name="cep_funcionario" id="alterar-cep_funcionario" maxlength="9" placeholder="Digite o CEP (ex: 00000-000)">
                <i class="ri-search-line busca_lupa" onclick="buscarCEPFuncionario()"></i>
            </div>

            <label>Rua:</label>
            <input type="text" name="rua_funcionario" id="alterar-rua_funcionario">

            <label>Número:</label>
            <input type="text" name="numero_funcionario" id="alterar-numero_funcionario">

            <label>Bairro:</label>
            <input type="text" name="bairro_funcionario" id="alterar-bairro_funcionario">

            <label>Cidade:</label>
            <input type="text" name="cidade_funcionario" id="alterar-cidade_funcionario">

            <label>UF:</label>
            <select name="uf_funcionario" id="alterar-uf_funcionario">
                <option value="">Selecione o estado</option>
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

// Função para buscar CEP do funcionário
function buscarCEPFuncionario() {
    const cepInput = document.getElementById("alterar-cep_funcionario");
    const cep = cepInput.value.replace(/\D/g, '');
    
    if (cep.length !== 8) {
        alert("Por favor, digite um CEP válido com 8 dígitos.");
        return;
    }
    
    // Exibir indicador de carregamento
    const lupaIcon = document.querySelector("#modalEditarFuncionario .busca_lupa");
    const originalClass = lupaIcon.className;
    lupaIcon.className = "ri-loader-4-line busca_lupa animar";
    
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                alert("CEP não encontrado. Por favor, verifique o número digitado.");
            } else {
                // Preencher os campos com os dados do CEP
                document.getElementById("alterar-rua_funcionario").value = data.logradouro || '';
                document.getElementById("alterar-bairro_funcionario").value = data.bairro || '';
                document.getElementById("alterar-cidade_funcionario").value = data.localidade || '';
                document.getElementById("alterar-uf_funcionario").value = data.uf || '';
                
                // Dar foco no campo número após preencher os dados
                document.getElementById("alterar-numero_funcionario").focus();
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

// Preview da foto
function setupFotoPreview() {
    const fotoInput = document.getElementById("alterar-foto_funcionario");
    if (fotoInput) {
        fotoInput.addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("alterar-foto-preview").src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
}

// Aplicar máscaras quando o modal for aberto
document.addEventListener("DOMContentLoaded", () => {
    const modalAlterar = document.getElementById("modalEditarFuncionario");
    if (!modalAlterar) return;
    
    const fecharAlterar = modalAlterar.querySelector(".fechar");
    
    // Elementos que receberão máscaras
    const cpfInput = document.getElementById("alterar-cpf_funcionario");
    const telefoneInput = document.getElementById("alterar-telefone_funcionario");
    const cepInput = document.getElementById("alterar-cep_funcionario");
    
    // Setup do preview da foto
    setupFotoPreview();
    
    // Aplicar máscaras na digitação
    if (cpfInput) {
        cpfInput.addEventListener("input", function() {
            this.value = aplicarMascaraCPF(this.value);
        });
        
        cpfInput.addEventListener("blur", function() {
            this.value = aplicarMascaraCPF(this.value);
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
        
        // Permitir busca de CEP ao pressionar Enter
        cepInput.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                buscarCEPFuncionario();
            }
        });
    }

    // Event listener para botões de alterar funcionário
    document.querySelectorAll(".alterarfuncionario").forEach(botao => {
        botao.addEventListener("click", e => {
            e.preventDefault();

            // Preenche modal de alteração
            document.getElementById("alterar-id_funcionario").value = botao.dataset.id_funcionario || '';
            document.getElementById("alterar-nome_funcionario").value = botao.dataset.nome_funcionario || '';
            
            // Aplica máscaras aos valores ao preencher o modal
            if (cpfInput) cpfInput.value = aplicarMascaraCPF(botao.dataset.cpf_funcionario || '');
            document.getElementById("alterar-email_funcionario").value = botao.dataset.email_funcionario || '';
            if (telefoneInput) telefoneInput.value = aplicarMascaraTelefone(botao.dataset.telefone_funcionario || '');
            document.getElementById("alterar-data_admissao").value = botao.dataset.data_admissao || '';
            document.getElementById("alterar-salario").value = botao.dataset.salario || '';
            document.getElementById("alterar-id_funcao").value = botao.dataset.id_funcao || '';
            if (cepInput) cepInput.value = aplicarMascaraCEP(botao.dataset.cep_funcionario || '');
            
            document.getElementById("alterar-rua_funcionario").value = botao.dataset.rua_funcionario || '';
            document.getElementById("alterar-numero_funcionario").value = botao.dataset.numero_funcionario || '';
            document.getElementById("alterar-bairro_funcionario").value = botao.dataset.bairro_funcionario || '';
            document.getElementById("alterar-cidade_funcionario").value = botao.dataset.cidade_funcionario || '';
            document.getElementById("alterar-uf_funcionario").value = botao.dataset.uf_funcionario || '';
            
            // Preview da foto
            if (botao.dataset.foto) {
                document.getElementById("alterar-foto-preview").src = botao.dataset.foto;
            }

            // Campo de senha (deixa em branco por segurança)
            document.getElementById("alterar-senha").value = '';

            // Abre modal
            modalAlterar.style.display = "flex";
        });
    });

    // Fechar modal
    if (fecharAlterar) {
        fecharAlterar.addEventListener("click", () => {
            modalAlterar.style.display = "none";
        });
    }

    window.addEventListener("click", e => {
        if (e.target === modalAlterar) {
            modalAlterar.style.display = "none";
        }
    });
});

// Função auxiliar para preencher o modal de edição (pode ser chamada de outros lugares)
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
    }
    
    // Campo de senha (deixa em branco por segurança)
    document.getElementById("alterar-senha").value = '';
    
    // Abre modal
    modalAlterar.style.display = "flex";
}



</script>

<script>
// JavaScript para gerenciar as fotos
document.addEventListener("DOMContentLoaded", function() {
    // Preview da foto quando alterada
    const fotoInput = document.getElementById('alterar-foto_funcionario');
    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Verificar se é imagem
                if (!file.type.startsWith('image/')) {
                    alert('Por favor, selecione apenas arquivos de imagem.');
                    this.value = '';
                    return;
                }
                
                // Verificar tamanho (máximo 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('A imagem deve ter no máximo 2MB.');
                    this.value = '';
                    return;
                }
                
                // Fazer preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('alterar-foto-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Preencher modal de edição quando clicar em "Alterar"
    document.querySelectorAll('.alterarfuncionario').forEach(botao => {
        botao.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Preencher todos os campos...
            document.getElementById('alterar-id_funcionario').value = this.dataset.id_funcionario;
            
            // Preencher a foto
            const fotoPreview = document.getElementById('alterar-foto-preview');
            const fotoAtualInput = document.getElementById('foto_atual');
            
            fotoPreview.src = this.dataset.foto;        
            fotoAtualInput.value = this.dataset.foto;
            
            // Abrir modal
            document.getElementById('modalEditarFuncionario').style.display = 'flex';
        });
    });
});
</script>
