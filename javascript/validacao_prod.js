document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".formulario-cadastro");

    form.addEventListener("submit", function (event) {
        let valido = true;
        let mensagens = [];

        // Nome do produto
        const nome = document.getElementById("nome_produto").value.trim();
        if (nome.length < 3) {
            valido = false;
            mensagens.push("O nome do produto deve ter pelo menos 3 caracteres.");
        }

        const preco = document.getElementById("preco").value.trim();
        if (preco === "") {
            valido = false;
            mensagens.push("O campo preço não pode ficar vazio.");
        }

        // Unidade de Medida
        const unMedida = document.getElementById("unmedida").value;
        if (!unMedida) {
            valido = false;
            mensagens.push("Selecione a unidade de medida.");
        }

        // Quantidade
        const qtd = document.getElementById("quantidade_produto").value;
        if (qtd === "" || qtd <= 0) {
            valido = false;
            mensagens.push("Digite uma quantidade maior que zero.");
        }

        // Validade
        const validade = document.getElementById("validade").value;
        if (validade) {
            const hoje = new Date();
            const dataValidade = new Date(validade + "T00:00:00");
            if (dataValidade < hoje) {
                valido = false;
                mensagens.push("A data de validade não pode ser anterior a hoje.");
            }
        }

        // Fornecedor
        const fornecedor = document.getElementById("id_fornecedor").value;
        if (!fornecedor) {
            valido = false;
            mensagens.push("Selecione um fornecedor.");
        }

        // Imagem
        const imagem = document.getElementById("imagem_produto").files[0];
        if (!imagem) {
            valido = false;
            mensagens.push("Selecione uma imagem para o produto.");
        } else {
            const tiposPermitidos = ["image/png", "image/jpeg", "image/jpg", "image/gif"];
            if (!tiposPermitidos.includes(imagem.type)) {
                valido = false;
                mensagens.push("A imagem deve estar nos formatos: PNG, JPG, JPEG ou GIF.");
            }
        }

        // Mostrar mensagens de erro
        if (!valido) {
            event.preventDefault();
            alert(mensagens.join("\n"));
        }
    });
});
