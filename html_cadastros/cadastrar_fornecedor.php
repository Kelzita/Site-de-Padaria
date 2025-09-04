<?php
require_once '../php/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Fornecedor</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/style_cadastro.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="../javascript/jquery.min.js"></script>
    <script src="../javascript/inputmask.min.js"></script>
</head>
<body>
<header>
    <img src="../img/logo.png" alt="Logo" />
</header>

<div class="container">
    <h1>Cadastrar Fornecedor</h1>

    <form method="POST" action="../php/cadastro_fornecedor.php" class="formulario-cadastro" enctype="multipart/form-data">

        <label for="razao_social"><i class="fas fa-building"></i> Razão Social:</label>
        <input type="text" id="razao_social" name="razao_social" placeholder="Insira a razão social" required>

        <label for="responsavel"><i class="fas fa-user-tie"></i> Responsável:</label>
        <input type="text" id="responsavel" name="responsavel" placeholder="Insira o nome do responsável" required>

        <label for="cnpj_fornecedor">CNPJ:</label>
        <input type="text" id="cnpj_fornecedor" name="cnpj_fornecedor" placeholder="99.999.999/9999-99" maxlength="18" required>

        <label for="telefone_fornecedor"><i class="fas fa-phone"></i> Telefone:</label>
        <input type="text" id="telefone_fornecedor" name="telefone_fornecedor" placeholder="(00) 00000-0000" maxlength="15" required>

        <label for="email_fornecedor"><i class="fas fa-envelope"></i> E-mail:</label>
        <input type="email" id="email_fornecedor" name="email_fornecedor" placeholder="Insira o e-mail" required>

        <label for="cep_fornecedor"><i class="fas fa-map-pin"></i> CEP:</label>
        <input type="text" id="cep_fornecedor" name="cep_fornecedor" placeholder="00000-000" maxlength="9">

        <label for="rua_fornecedor"><i class="fas fa-road"></i> Rua:</label>
        <input type="text" id="rua_fornecedor" name="rua_fornecedor" placeholder="Insira a rua" required>

        <label for="numero_fornecedor"><i class="fas fa-home"></i> Número:</label>
        <input type="text" id="numero_fornecedor" name="numero_fornecedor" placeholder="Insira o número" required>

        <label for="bairro_fornecedor"><i class="fas fa-city"></i> Bairro:</label>
        <input type="text" id="bairro_fornecedor" name="bairro_fornecedor" placeholder="Insira o bairro" required>

        <label for="cidade_fornecedor"><i class="fas fa-building"></i> Cidade:</label>
        <input type="text" id="cidade_fornecedor" name="cidade_fornecedor" placeholder="Insira a cidade" required>

        <label for="uf_fornecedor"><i class="fas fa-flag"></i> UF:</label>
        <select id="uf_fornecedor" name="uf_fornecedor" required>
            <option value="" disabled selected>Escolha o Estado</option>
            <?php
            $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
            foreach($ufs as $uf){
                echo "<option value='$uf'>$uf</option>";
            }
            ?>
        </select>

        <label for="foto_fornecedor"><i class="fas fa-image"></i> Foto/Logo:</label>
        <input type="file" id="foto_fornecedor" name="foto_fornecedor" accept="image/*">

        <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Cadastrar</button>
    </form>
</div>
</body>
</html>
