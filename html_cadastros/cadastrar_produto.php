<?php 
require_once '../php/funcoes.php';
?>


<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- jQuery primeiro -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JS do Select2 depois -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/style_cadastro.css" />
    

</head>

<body>
    <header>
        <img src="../img/logo.png" alt="Logo">
        <!--Menu-->
    </header>
    <div class="container">
        <h1>Cadastrar Produto</h1>
        <form class="formulario-cadastro" method="POST" action="../php/cadastro_produto.php" onsubmit="return validacaoProduto(event)" enctype="multipart/form-data">

            <label for="nome_produto"><i class="fas fa-barcode"></i> Nome do Produto:</label>
            <input type="text" id="nome_produto" name="nome_produto" placeholder="Insira o nome do produto" >

            <label for="descricao"><i class="ri-file-text-line"></i> Descrição:</label>
            <textarea id="descricao" name="descricao" placeholder="Insira o nome do produto" ></textarea>

            <label for="preco"><i class="fas fa-dollar-sign"></i> Preço:</label>
            <input type="number" step="0.01" id="preco" name="preco" placeholder="R$ 0,00" >

            <label for="unmedida"><i class="fas fa-cube"></i> Unidade de Medida:</label>
            <input type="text" id="unmedida" name="unmedida" placeholder="Ex: Kg, un, L" >
            <div class="input-group">
            
            <label for="quantidade"><i class="fas fa-boxes"></i> Quantidade do Produto:</label>
            <input type="number" id="quantidade_produto"  name="quantidade_produto"  placeholder="Digite a quantidade disponível" min="1" >
            
            <label for="validade"><i class="fas fa-calendar-alt"></i> Validade:</label>
            <input type="date" id="validade" name="validade" >

            
            <label for="id_fornecedor"><i class="fas fa-truck"></i> Fornecedor:</label>
            <select name="id_fornecedor" id="id_fornecedor">
                 <option value="">Selecione o fornecedor</option>
                <?php foreach ($fornecedores as $fornecedor): ?>
               <option value="<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>">
              <?= htmlspecialchars($fornecedor['id_fornecedor'] . ' - ' . $fornecedor['razao_social']) ?>
                </option>
            <?php endforeach; ?>
            </select>

            <label for="imagem_produto"><i class="fa-solid fa-image"></i> Foto do Produto:</label>
            <input type="file"name="imagem_produto" id="imagem_produto" required></input>

            <input type="hidden" name="id_estoque" id="id_estoque" >


            <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Cadastrar</button>
        </form>
    </div>
    <script src="../js/validacao_cad_produto.js"></script>
  

</body>

</html>