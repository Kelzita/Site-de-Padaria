document.addEventListener("DOMContentLoaded", function () {

    // Funções utilitárias
    function isNotEmpty(value) {
        return value.trim() !== "";
    }

    function validarEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
        return re.test(email);
    }

    function validarTelefone(telefone) {
        telefone = telefone.replace(/\D/g, '');
        return telefone.length === 10 || telefone.length === 11;
    }

    function validarCEP(cep) {
        cep = cep.replace(/\D/g, '');
        return cep.length === 8;
    }

    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/\D/g, ''); // só números
        return cnpj.length === 14;
    }

    // Seleciona o formulário
    const formFornecedor = document.querySelector("#formFornecedor");

    if (formFornecedor) {
        formFornecedor.addEventListener("submit", function (e) {
            let erros = [];

            // Campos obrigatórios
            const camposObrigatorios = [
                { id: "razao_social", nome: "Razão Social" },
                { id: "responsavel", nome: "Responsável" },
                { id: "cnpj_fornecedor", nome: "CNPJ" },
                { id: "telefone_fornecedor", nome: "Telefone" },
                { id: "email_fornecedor", nome: "E-mail" },
                { id: "cep_fornecedor", nome: "CEP" },
                { id: "rua_fornecedor", nome: "Rua" },
                { id: "numero_fornecedor", nome: "Número" },
                { id: "bairro_fornecedor", nome: "Bairro" },
                { id: "cidade_fornecedor", nome: "Cidade" },
                { id: "uf_fornecedor", nome: "UF" }
            ];

            camposObrigatorios.forEach(campo => {
                const input = document.querySelector(`#${campo.id}`);
                if (!isNotEmpty(input.value)) {
                    erros.push(`${campo.nome} não pode estar vazio.`);
                }
            });

            // Validações específicas
            const cnpj = document.querySelector("#cnpj_fornecedor").value;
            if (isNotEmpty(cnpj) && !validarCNPJ(cnpj)) {
                erros.push("CNPJ inválido. Deve ter 14 dígitos numéricos.");
            }

            const telefone = document.querySelector("#telefone_fornecedor").value;
            if (isNotEmpty(telefone) && !validarTelefone(telefone)) {
                erros.push("Telefone inválido. Deve ter 10 ou 11 dígitos.");
            }

            const email = document.querySelector("#email_fornecedor").value;
            if (isNotEmpty(email) && !validarEmail(email)) {
                erros.push("E-mail inválido.");
            }

            const cep = document.querySelector("#cep_fornecedor").value;
            if (isNotEmpty(cep) && !validarCEP(cep)) {
                erros.push("CEP inválido. Deve ter 8 dígitos.");
            }

            if (erros.length > 0) {
                e.preventDefault(); // 🔒 não envia o formulário
                alert(erros.join("\n"));
            }
        });
    }
});

