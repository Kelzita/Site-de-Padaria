document.addEventListener("DOMContentLoaded", function () {
    // Funções utilitárias
    function isNotEmpty(value) {
        return value.trim() !== "";
    }

    function validarPreco(preco) {
        // remove R$, pontos e vírgulas
        preco = preco.replace(/[R$\s.]/g, '').replace(',', '.');
        let valor = parseFloat(preco);
        return !isNaN(valor) && valor > 0;
    }

    // Seleciona o formulário
    const formProduto = document.querySelector("#formulario-editar-produto");

    if (formProduto) {
        formProduto.addEventListener("submit", function (e) {
            let erros = [];

            // Campos obrigatórios
            const camposObrigatorios = [
                { id: "nome_produto", nome: "Nome do Produto" },
                { id: "descricao", nome: "Descrição" },
                { id: "preco", nome: "Preço" },
                { id: "unmedida", nome: "Unidade de Medida" },
                { id: "validade", nome: "Validade" },
                { id: "quantidade_produto", nome: "Quantidade" },
                { id: "razao_social", nome: "Razão Social" }
            ];

            camposObrigatorios.forEach(campo => {
                const input = document.querySelector(`#${campo.id}`);
                if (!isNotEmpty(input.value)) {
                    erros.push(`${campo.nome} não pode estar vazio.`);
                }
            });

            // Validação de preço
            const preco = document.querySelector("#preco").value;
            if (isNotEmpty(preco) && !validarPreco(preco)) {
                erros.push("Preço inválido. Informe um valor maior que 0.");
            }

            // Validação da validade
            const validade = document.querySelector("#validade").value;
            if (isNotEmpty(validade)) {
                const hoje = new Date().toISOString().split("T")[0];
                if (validade < hoje) {
                    erros.push("A validade não pode ser anterior à data de hoje.");
                }
            }

            // Validação de quantidade
            const quantidade = document.querySelector("#quantidade_produto").value;
            if (isNotEmpty(quantidade) && parseInt(quantidade) < 0) {
                erros.push("Quantidade não pode ser negativa.");
            }

            if (erros.length > 0) {
                e.preventDefault(); // 🔒 trava envio
                alert(erros.join("\n"));
            }
        });
    }
});
