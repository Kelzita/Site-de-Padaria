document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".formulario-cadastro");

    form.addEventListener("submit", function (event) {
        let valido = true;
        let mensagens = [];

        // Nome
        const nome = document.getElementById("nome_funcionario").value.trim();
        if (nome === "") {
            valido = false;
            mensagens.push("O campo nome não pode ficar vazio.");
        }

        // CPF
        const cpf = document.getElementById("cpf_funcionario").value.trim();
        if (cpf === "") {
            valido = false;
            mensagens.push("O campo CPF não pode ficar vazio.");
        }

        // E-mail
        const email = document.getElementById("email_funcionario").value.trim();
        if (email === "") {
            valido = false;
            mensagens.push("O campo e-mail não pode ficar vazio.");
        }

        // Senha
        const senha = document.getElementById("senha").value.trim();
        if (senha === "") {
            valido = false;
            mensagens.push("O campo senha não pode ficar vazio.");
        }

        // Telefone
        const telefone = document.getElementById("telefone_funcionario").value.trim();
        if (telefone === "") {
            valido = false;
            mensagens.push("O campo telefone não pode ficar vazio.");
        }

        // CEP
        const cep = document.getElementById("cep_funcionario").value.trim();
        if (cep === "") {
            valido = false;
            mensagens.push("O campo CEP não pode ficar vazio.");
        }

        // Rua
        const rua = document.getElementById("rua_funcionario").value.trim();
        if (rua === "") {
            valido = false;
            mensagens.push("O campo rua não pode ficar vazio.");
        }

        // Número
        const numero = document.getElementById("numero_funcionario").value.trim();
        if (numero === "") {
            valido = false;
            mensagens.push("O campo número não pode ficar vazio.");
        }

        // Bairro
        const bairro = document.getElementById("bairro_funcionario").value.trim();
        if (bairro === "") {
            valido = false;
            mensagens.push("O campo bairro não pode ficar vazio.");
        }

        // Cidade
        const cidade = document.getElementById("cidade_funcionario").value.trim();
        if (cidade === "") {
            valido = false;
            mensagens.push("O campo cidade não pode ficar vazio.");
        }

        // UF
        const uf = document.getElementById("uf_funcionario").value;
        if (!uf) {
            valido = false;
            mensagens.push("Selecione o estado (UF).");
        }

        // Data de Admissão
        const data = document.getElementById("data_admissao").value;
        if (data === "") {
            valido = false;
            mensagens.push("O campo data de admissão não pode ficar vazio.");
        }

        // Salário
        const salario = document.getElementById("salario").value.trim();
        if (salario === "") {
            valido = false;
            mensagens.push("O campo salário não pode ficar vazio.");
        }

        // Função
        const funcao = document.getElementById("id_funcao").value;
        if (!funcao) {
            valido = false;
            mensagens.push("Selecione uma função.");
        }

        // Se algum campo inválido, impedir envio e mostrar mensagens
        if (!valido) {
            event.preventDefault();
            alert(mensagens.join("\n"));
        }
    });
});
