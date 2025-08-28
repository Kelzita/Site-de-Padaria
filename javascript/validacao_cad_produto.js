let nome_produto = document.getElementById("nome_produto");
    let preco = document.getElementById("preco");
    let unmedida = document.getElementById("unmedida");
    let quantidade_produto = document.getElementById("quantidade_produto");
    let validade_produto = document.getElementById("validade_produto");
    let id_fornecedor = document.getElementById("id_fornecedor");

    let hoje = new Date().toISOString().split("T")[0];
    validade_produto.min = hoje;

    function validacaoProduto(event) {


        if(nome_produto.value.trim() === "") {
            alert("Preencha o campo Nome do Produto!");
            nome_produto.focus();
            return false;
        }
        if(nome_produto.value.trim().length < 3) {
            alert("O nome do produto deve ter pelo menos 3 caracteres!");
            nome_produto.focus();
            return false;
        }

        if(preco.value.trim() === "") {
            alert("Preencha o campo Preço!");
            preco.focus();
            return false;
        }
        if(preco.value <= 0) {
            alert("O preço deve ser maior que zero!");
            preco.focus();
            return false;
        }

      
        if(unmedida.value.trim() === "") {
            alert("Preencha o campo Unidade de Medida!");
            unmedida.focus();
            return false;
        }

  
        if(quantidade_produto.value.trim() === "") {
            alert("Preencha o campo Quantidade do Produto!");
            quantidade_produto.focus();
            return false;
        }
        if(Number(quantidade_produto.value) <= 0) {
            alert("A quantidade deve ser maior que zero!");
            quantidade_produto.focus();
            return false;
        }


        if(validade_produto.value === "") {
            alert("Informe a data de validade!");
            validade_produto.focus();
            return false;
        }
        if(validade_produto.value < hoje) {
            alert("A data de validade não pode ser passada!");
            validade_produto.focus();
            return false;
        }

        if(id_fornecedor.value === "") {
            alert("Selecione o fornecedor!");
            id_fornecedor.focus();
            return false;
        }

        return true;
    }

