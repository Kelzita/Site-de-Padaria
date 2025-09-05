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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../javascript/inputmask.min.js"></script>
</head>
<body>
<header>
    <img src="../img/logo.png" alt="Logo" />
</header>

<div class="container">
    <h1>Cadastrar Fornecedor</h1>

    <form method="POST" action="../php/cadastro_fornecedor.php" class="formulario-cadastro">

        <label for="razao_social"><i class="fas fa-building"></i> Razão Social:</label>
        <input type="text" id="razao_social" name="razao_social" placeholder="Insira a razão social" >

        <label for="responsavel"><i class="fas fa-user-tie"></i> Responsável:</label>
        <input type="text" id="responsavel" name="responsavel" placeholder="Insira o nome do responsável" >

        <label for="cnpj_fornecedor"><i class="fas fa-id-card"></i> CNPJ:</label>
        <input type="text" id="cnpj_fornecedor" name="cnpj_fornecedor" placeholder="99.999.999/9999-99" maxlength="18" >

        <label for="telefone_fornecedor"><i class="fas fa-phone"></i> Telefone:</label>
        <input type="text" id="telefone_fornecedor" name="telefone_fornecedor" placeholder="(00) 00000-0000" maxlength="15" >

        <label for="email_fornecedor"><i class="fas fa-envelope"></i> E-mail:</label>
        <input type="email" id="email_fornecedor" name="email_fornecedor" placeholder="Insira o e-mail" >

        <label for="cep_fornecedor"><i class="fas fa-map-pin"></i> CEP:</label>
        <div class="input-container-cep">
            <input type="text" id="cep_fornecedor" name="cep_fornecedor" placeholder="00000-000" maxlength="9">
            <i class="ri-search-line busca_lupa" onclick="buscarCEPFornecedor()"></i>
        </div>

        <label for="rua_fornecedor"><i class="fas fa-road"></i> Rua:</label>
        <input type="text" id="rua_fornecedor" name="rua_fornecedor" placeholder="Insira a rua" >

        <label for="numero_fornecedor"><i class="fas fa-home"></i> Número:</label>
        <input type="text" id="numero_fornecedor" name="numero_fornecedor" placeholder="Insira o número" >

        <label for="bairro_fornecedor"><i class="fas fa-city"></i> Bairro:</label>
        <input type="text" id="bairro_fornecedor" name="bairro_fornecedor" placeholder="Insira o bairro" >

        <label for="cidade_fornecedor"><i class="fas fa-building"></i> Cidade:</label>
        <input type="text" id="cidade_fornecedor" name="cidade_fornecedor" placeholder="Insira a cidade" >

        <label for="uf_fornecedor"><i class="fas fa-flag"></i> UF:</label>
        <select id="uf_fornecedor" name="uf_fornecedor" >
            <option value="" disabled selected>Escolha o Estado</option>
            <?php
            $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
            foreach($ufs as $uf){
                echo "<option value='$uf'>$uf</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Cadastrar</button>
    </form>
</div>

<a href='../inicio/home.php' class="voltar"> 
    <img class="seta1" src="../img/btn_voltar.png" title="Voltar">
</a>

<script src="../javascript/funcoes.js"></script>
<script src="../javascript/validacoes.js"></script>
<script>
    // Máscaras
    $(document).ready(function(){
        $('#cnpj_fornecedor').inputmask('99.999.999/9999-99');
        $('#telefone_fornecedor').inputmask('(99) 99999-9999');
        $('#cep_fornecedor').inputmask('99999-999');
    });
</script>
</body>
</html>
