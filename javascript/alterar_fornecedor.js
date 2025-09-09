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
        telefone = telefone.replace(/\D/g, ''); // remove máscara
        return telefone.length === 10 || telefone.length === 11;
    }

    function validarCEP(cep) {
        cep = cep.replace(/\D/g, '');
        return cep.length === 8;
    }

    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/\D/g, ''); // remove máscara
        return cnpj.length === 14;
    }

    // Seleciona o formulário
    const formFornecedor = document.querySelector("#formulario-editar-fornecedor");

    if (formFornecedor) {
        formFornecedor.addEventListener("submit", function (e) {
            let erros = [];

            // Campos obrigatórios
            const camposObrigatorios = [
                { name: "razao_social", nome: "Razão Social" },
                { name: "responsavel", nome: "Responsável" },
                { name: "cnpj_fornecedor", nome: "CNPJ" },
                { name: "telefone_fornecedor", nome: "Telefone" },
                { name: "email_fornecedor", nome: "E-mail" },
                { name: "cep_fornecedor", nome: "CEP" },
                { name: "rua_fornecedor", nome: "Rua" },
                { name: "numero_fornecedor", nome: "Número" },
                { name: "bairro_fornecedor", nome: "Bairro" },
                { name: "cidade_fornecedor", nome: "Cidade" },
                { name: "uf_fornecedor", nome: "UF" }
            ];

            camposObrigatorios.forEach(campo => {
                const input = document.querySelector(`[name='${campo.name}']`);
                if (!input || !isNotEmpty(input.value)) {
                    erros.push(`${campo.nome} não pode estar vazio.`);
                }
            });

            // Validações específicas
            const cnpj = document.querySelector("[name='cnpj_fornecedor']").value;
            if (isNotEmpty(cnpj) && !validarCNPJ(cnpj)) {
                erros.push("CNPJ inválido. Deve conter 14 dígitos numéricos.");
            }

            const telefone = document.querySelector("[name='telefone_fornecedor']").value;
            if (isNotEmpty(telefone) && !validarTelefone(telefone)) {
                erros.push("Telefone inválido. Deve ter 10 ou 11 dígitos.");
            }

            const email = document.querySelector("[name='email_fornecedor']").value;
            if (isNotEmpty(email) && !validarEmail(email)) {
                erros.push("E-mail inválido.");
            }

            const cep = document.querySelector("[name='cep_fornecedor']").value;
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
