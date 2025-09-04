function validacaoProduto(event) {
    event.preventDefault();

    const nomeProduto = document.getElementById('nome_produto').value.trim();

    const precoRaw = document.getElementById('preco').value.trim();
    const precoLimpo = precoRaw.replace(/[^\d,\.]/g, '').replace(',', '.');

    const unMedida = document.getElementById('unmedida').value;
    const quantidade = document.getElementById('quantidade_produto').value;
    const validade = document.getElementById('validade').value;
    const fornecedor = document.getElementById('id_fornecedor').value;
    const imagem = document.getElementById('imagem_produto').files[0];

    let mensagemErro = '';

    if (nomeProduto === '') {
        mensagemErro += '- O campo "Nome do Produto" é obrigatório.\n';
    }

    if (precoLimpo === '' || isNaN(precoLimpo) || parseFloat(precoLimpo) <= 0) {
        mensagemErro += '- O preço deve ser maior que R$ 0,00.\n';
    }

    if (!unMedida) {
        mensagemErro += '- Selecione uma unidade de medida.\n';
    }

    if (quantidade === '' || isNaN(quantidade) || parseInt(quantidade) <= 0) {
        mensagemErro += '- A quantidade deve ser um número inteiro positivo.\n';
    }

    if (!validade) {
        mensagemErro += '- O campo "Validade" é obrigatório.\n';
    } else {
        const hoje = new Date().toISOString().split('T')[0];
        if (validade < hoje) {
            mensagemErro += '- A data de validade não pode ser anterior à data de hoje.\n';
        }
    }

    if (!fornecedor) {
        mensagemErro += '- Selecione um fornecedor.\n';
    }

    if (!imagem) {
        mensagemErro += '- Selecione uma imagem do produto.\n';
    }

    if (mensagemErro !== '') {
        alert('Corrija os seguintes erros:\n\n' + mensagemErro);
        return false;
    }

    event.target.submit();
}






// ======= MÁSCARA PARA O PREÇO DE CADASTRAR PRODUTO! ========

document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("preco");

    input.addEventListener("input", () => {
        let valor = input.value.replace(/\D/g, ""); // remove tudo que não é número
        if (valor === "") {
            input.value = "";
            return;
        }
        valor = (valor / 100).toFixed(2) + ""; // coloca duas casas
        valor = valor.replace(".", ","); // vírgula nos centavos
        valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // pontos de milhar
        input.value = "R$ " + valor;
    });
});

$('#foto_produto').change(function() {
    if(this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#foto_produto_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("preco");

    input.addEventListener("input", () => {
        let valor = input.value.replace(/\D/g, ""); // tira tudo que não for número
        valor = (valor / 100).toFixed(2) + ""; // divide por 100 para ter duas casas decimais
        valor = valor.replace(".", ","); // vírgula para decimais
        valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // adiciona pontos de milhar
        input.value = "R$ " + valor;
    });
});
