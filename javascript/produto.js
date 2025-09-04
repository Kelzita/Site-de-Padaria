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


