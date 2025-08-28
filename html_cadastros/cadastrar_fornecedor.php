<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Fornecedor</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/style_cadastro.css" />

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../javascript/inputmask.min.js"></script>
</head>
<body>
    <header>
        <img src="../img/logo.png" />
        <!--Menu-->
    </header>
    <div class="container">
        <h1>Cadastrar Fornecedor</h1>
        <form class="formulario-cadastro" method="POST" action="../php/cadastro_fornecedor.php">

            <label for="razao_social"><i class="fas fa-building"></i> Razão Social:</label>
            <input type="text" id="razao_social" name="razao_social" placeholder="Insira a razão social" />

            <label for="responsavel"><i class="fas fa-user-tie"></i> Responsável:</label>
            <input type="text" id="responsavel" name="responsavel" placeholder="Insira o nome do responsável" />

            <label for="cnpj_fornecedor">CNPJ:</label>
<input type="text" id="cnpj_fornecedor" name="cnpj_fornecedor" placeholder=" Insira o CNPJ (ex.99.999.999/9999-99)" maxlength="18" />

            <label for="telefone_fornecedor"><i class="fas fa-phone"></i> Telefone:</label>
            <input type="text" id="telefone_fornecedor" name="telefone_fornecedor" pattern="\(\d{2}\) \d{4,5}-\d{4}"
                maxlength="15" placeholder="(00) 00000-0000" title="Formato: (00) 00000-0000" />

            <label for="email_fornecedor"><i class="fas fa-envelope"></i> E-mail:</label>
            <input type="email" id="email_fornecedor" name="email_fornecedor" placeholder="Insira o e-mail" />

            <label for="cep_fornecedor"><i class="fas fa-map-pin"></i> CEP:</label>
            <div class="input-container-cep">
                <input type="text" id="cep_fornecedor" name="cep_fornecedor" placeholder="Insira o CEP" maxlength="9" oninput="formatCEP(this)">
                 <i class="ri-search-line busca_lupa" onclick="buscarCEPFornecedor()"></i>
            </div>

            <label for="rua_fornecedor"><i class="fas fa-road"></i> Rua:</label>
            <input name="rua_fornecedor" type="text" id="rua_fornecedor" placeholder="Insira a rua">

            <label for="numero_fornecedor"><i class="fas fa-home"></i> Número:</label>
            <input name="numero_fornecedor" type="text" id="numero_fornecedor" placeholder="Insira o número">

            <label for="bairro_fornecedor"><i class="fas fa-city"></i> Bairro:</label>
            <input name="bairro_fornecedor" type="text" id="bairro_fornecedor" placeholder="Insira o bairro">

            <label for="cidade_fornecedor"><i class="fas fa-building"></i> Cidade:</label>
            <input name="cidade_fornecedor" type="text" id="cidade_fornecedor" placeholder="Insira a cidade">

            <label for="uf_fornecedor"><i class="fas fa-flag"></i> UF:</label>
            <select id="uf_fornecedor" name="uf_fornecedor">
                <option value="" selected disabled>Escolha o Estado</option>
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>
            

            <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Cadastrar</button>
        </form>
    </div>
    <script src="../javascript/funcoes.js"></script>
</body>

</html>