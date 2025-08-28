<!DOCTYPE html>
<html lang="pt-BR">
<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Caixa</title>
        <link rel="stylesheet" href="../css/styleCaixa.css" />
</head>
<body>
    <div class="box_principal">

        <div class="box_header">
            <h2>CAIXA ABERTO- PADARIA PÃO GENIAL 🍞</h2>
        </div>

        <div class="box_logo">
            <img src="../img/logo.png" alt="Logo da Padaria Pão Genial">
        </div>

        <div class="box_comanda">
            <!--Formulário para buscar comanda-->
            <form action="buscar_comanda.php" method="POST">
                <label for="id_comanda">ID da Comanda:</label>
                <input type="number" id="id_comanda" name="id_comanda" placeholder="Digite o ID da Comanda">
                <button class="buscarComanda" type="submit">Buscar</button> 
                <button class="apagarBuscarComanda" type="button">Apagar</button>
            </form>
        </div>

        <div class="box_listaProdutos">
            <table>
                <h2>Lista de Produtos</h2>
                <tr>
                    <th>Item</th>
                    <th>Nome</th>
                    <th>Qtd</th>
                    <th>Vlr. Unit.</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
                <!--Fazer com php os itens escolhidos-->
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="box_codigo_prod">
            <!--Formlário para buscar produtos pelo código deles-->
            <form action="buscar_codProd.php" method="POST">
                <label for="cod_prod">Código do Produto:</label>
                <input type="number" id="cod_prod" name="cod_comanda" placeholder="Insira o código...">
                <button class="buscarCodProd" type="submit">Buscar</button> 
            </form>
        </div>
        <div class="resumo">
            <div><strong>SUBTOTAL:</strong><span class="destaque" id="subtotal">R$ 0,00</span></div>
        </div>
        <div class="comandos">
            <button>Pesquisar Produto</button>
            
            <button>Finalizar Venda</button>
            
            <button>Sair</button>
        </div>
    </div>
</body>
</html>
