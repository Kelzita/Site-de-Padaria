<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comanda</title>
</head>
<body>
    <h1>Adicionar Produto na Comanda</h1>
    <form action="seu_arquivo.php" method="get">
        <label for="id_produto">ID do Produto:</label>
        <input type="number" name="id_produto" id="id_produto" required><br><br>

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" value="1" min="1"><br><br>

        <label for="observacao">Observação:</label>
        <input type="text" name="observacao" id="observacao"><br><br>

        <button type="submit">Adicionar</button>
    </form>

    <h2>Itens da Comanda</h2>
    <div id="lista-itens"></div>

    <script>
        const form = document.querySelector("form");
        const listaItens = document.getElementById("lista-itens");

        form.addEventListener("submit", function(e) {
            e.preventDefault();

            const params = new URLSearchParams(new FormData(form));
            
            fetch("seu_arquivo.php?" + params)
                .then(res => res.json())
                .then(data => {
                    if (data.erro) {
                        listaItens.innerHTML = "<p style='color:red'>" + data.erro + "</p>";
                        return;
                    }
                    
                    let html = "<table border='1' cellpadding='5'><tr><th>Produto</th><th>Quantidade</th><th>Valor Unit.</th><th>Total</th></tr>";
                    data.forEach(item => {
                        html += `<tr>
                                    <td>${item.nome_produto}</td>
                                    <td>${item.quantidade}</td>
                                    <td>R$ ${item.valor_unit}</td>
                                    <td>R$ ${item.total}</td>
                                </tr>`;
                    });
                    html += "</table>";

                    listaItens.innerHTML = html;
                })
                .catch(err => {
                    listaItens.innerHTML = "<p style='color:red'>Erro ao carregar itens</p>";
                });
        });
    </script>
</body>
</html>
