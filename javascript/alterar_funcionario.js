document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formulario-editar-funcionario");

    form.addEventListener("submit", function (e) {
        let erros = [];

        // Nome
        const nome = document.getElementById("nome_funcionario").value.trim();
        if (nome === "") {
            erros.push("O campo Nome é obrigatório.");
        }

        // CPF
        const cpf = document.getElementById("cpf_funcionario").value.replace(/\D/g, "");
        if (cpf === "") {
            erros.push("O campo CPF é obrigatório.");
        } else if (cpf.length !== 11) {
            erros.push("CPF inválido. Digite os 11 números.");
        }

        // E-mail
        const email = document.getElementById("email_funcionario").value.trim();
        if (email === "") {
            erros.push("O campo E-mail é obrigatório.");
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            erros.push("E-mail inválido.");
        }

        // Telefone
        const telefone = document.getElementById("telefone_funcionario").value.replace(/\D/g, "");
        if (telefone !== "" && telefone.length < 10) {
            erros.push("Telefone inválido. Preencha com DDD e número.");
        }

        // Senha → pode ficar em branco, mas se preenchida, tem que ter mínimo 6
        const senha = document.getElementById("senha").value;
        if (senha !== "" && senha.length < 6) {
            erros.push("A senha deve ter pelo menos 6 caracteres.");
        }

        // Data de Admissão
        const dataAdmissao = document.getElementById("data_admissao").value;
        if (dataAdmissao === "") {
            erros.push("A Data de Admissão é obrigatória.");
        }

        // Salário
        const salario = document.getElementById("salario").value;
        if (salario === "") {
            erros.push("O campo Salário é obrigatório.");
        } else if (parseFloat(salario) <= 0) {
            erros.push("O Salário deve ser maior que zero.");
        }

        // Função
        const funcao = document.getElementById("id_funcao").value;
        if (funcao === "" || funcao === "Selecione a Função") {
            erros.push("Selecione uma Função.");
        }

        // Endereço
        const cep = document.getElementById("cep_funcionario").value.replace(/\D/g, "");
        if (cep === "") {
            erros.push("O campo CEP é obrigatório.");
        } else if (cep.length !== 8) {
            erros.push("CEP inválido.");
        }

        const rua = document.getElementById("rua_funcionario").value.trim();
        if (rua === "") {
            erros.push("O campo Rua é obrigatório.");
        }

        const numero = document.getElementById("numero_funcionario").value.trim();
        if (numero === "") {
            erros.push("O campo Número é obrigatório.");
        }

        const bairro = document.getElementById("bairro_funcionario").value.trim();
        if (bairro === "") {
            erros.push("O campo Bairro é obrigatório.");
        }

        const cidade = document.getElementById("cidade_funcionario").value.trim();
        if (cidade === "") {
            erros.push("O campo Cidade é obrigatório.");
        }

        const uf = document.getElementById("uf_funcionario").value;
        if (uf === "") {
            erros.push("Selecione o Estado (UF).");
        }

        // Se houver erros, bloquear envio e mostrar alertas
        if (erros.length > 0) {
            e.preventDefault();
            alert(erros.join("\n"));
        }
    });
});
