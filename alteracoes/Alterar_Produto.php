<?php 
require_once '../php/funcoes.php';

//Obter o ID do produto da URL
$id_produto = isset($_GET['id']) ? intval($_GET['id']) : 0; // Intval converte o valor para INT

$produto = null;

if($id_produto > 0) {
    $produto = buscarProdutoPorId($id_produto);
}
// Se não encontra o rpoduto redireciona
/*if(!$produto) {
    header ('Location: ../html_listas/lista_de_produto.php');
    exit;
}*/


?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/alterar.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <title>Editar Produto</title>
</head>
<body>
    <header>
        <img src="../img/logo.png">
    </header>

<div class="modal-editar">
    <div class="modal-editar__container">
        <div class="modal-editar__header">
            <h2 class="modal-editar__titulo">Editar Produto</h2>
            <a href="../html_listas/lista_de_produto.php" class="modal-editar__fechar">&times;</a>
        </div>

        <form id="formulario-editar-produto" class="formulario" action="../php/alterar_produto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">

            <div class="grupo-formulario grupo-formulario--completo"> 
                <div class="container-foto">
                    <?php if (!empty($produto['imagem_produto'])) : ?>
                        <img src="data:image/jpeg;base64, <?=base64_encode($produto['imagem_produto']) ?>" alt="Foto do Funcionário" class="previsualizacao-foto" id="foto_produto_preview">
                <?php else: ?>
                    <img src="data:image/svg+xml;base64,PHN2ZyBmaWxsPSIjQkFCQUJBIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjAiIGhlaWdodD0iMTIwIiB2aWV3Qm94PSIwIDAgMjQgMjQiPgogIDxwYXRoIGQ9Ik0yIDEwbDQtMyA4IDQtOCA0LTQtM3ptMTYgMGwtNCAzLTgtNCA4LTQgNCAzeiIvPgogIDxwYXRoIGQ9Ik0yIDEwbDEwIDUgMTAtNSIvPgogIDxwYXRoIGQ9Ik0yIDEwbDEwIDV2OWwtMTAtNXoiLz4KICA8cGF0aCBkPSJNMTIgMTVsMTAtNXY5bC0xMCA1eiIvPgo8L3N2Zz4=" 
                    alt="Produto padrão" class="previsualizacao-foto" id="foto_produto_preview">
                <?php endif ;?>
                <input type="file" name="foto_produto" id="foto_produto" class="entrada-foto" accept="image/*">
                <label for="foto_produto" class="rotulo-foto">
                <i class="ri-camera-line"></i> Alterar Foto</label>
                <p class="instrucoes-foto">Clique na imagem ou no botão para alterar a foto</p>
                <input type="hidden" name="foto_atual" id="foto_atual" value="<?=!empty($produto['imagem_produto']) ? base64_encode($produto['imagem_produto']) : '' ?>">

                </div>
        </div>

        <!-- Dados do Produto -->

        <div class="grupo-formulario">
            <label for="nome_produto" class="rotulo-formulario">Nome do Produto:</label>
            <input type="text" name="nome_produto" id="nome_produto" class="entrada-formulario" value="<?= htmlspecialchars($produto['nome_produto']) ?>" required>
        </div>

        <div class="grupo-formulario">
            <label for="descricao" class="rotulo-formulario">Descrição:</label>
            <textarea name="descricao" id="descricao" class="entrada-formulario" required><?= htmlspecialchars($produto['descricao']) ?></textarea>

        </div>

        <div class="grupo-formulario">
            <label for="preco" class="rotulo-formulario">Preço:</label>
            <textarea name="descricao" id="descricao" class="entrada-formulario" required><?= htmlspecialchars($produto['descricao']) ?></textarea>
        </div>

        
        <div class="grupo-formulario">
    <label for="unmedida" class="rotulo-formulario">Unidade de Medida:</label>
    <select name="unmedida" id="unmedida" class="entrada-formulario" required>
        <option value="" disabled <?= empty($produto['unmedida']) ? 'selected' : '' ?>>Selecione...</option>

        <option value="un" <?= ($produto['unmedida'] ?? '') === 'un' ? 'selected' : '' ?>>Unidade (un)</option>
        <option value="kg" <?= ($produto['unmedida'] ?? '') === 'kg' ? 'selected' : '' ?>>Quilo (kg)</option>
        <option value="g" <?= ($produto['unmedida'] ?? '') === 'g' ? 'selected' : '' ?>>Grama (g)</option>
        <option value="l" <?= ($produto['unmedida'] ?? '') === 'l' ? 'selected' : '' ?>>Litro (L)</option>
    </select>
</div>


        <div class="grupo-formulario">
            <label for="validade" class="rotulo-formulario">Validade:</label>
            <input type="date" name="validade" id="validade" class="entrada-formulario" value="<?= htmlspecialchars($produto['validade']) ?>" required/>
        </div>

        <div class="grupo-formulario">
            <label for="quantidade_produto" class="rotulo-formulario">Quantidade:</label>
            <input type="number" name="quantidade_produto" id="quantidade_produto" class="entrada-formulario" value="<?= htmlspecialchars($produto['quantidade_produto']) ?>" required/>
        </div>

        <div class="acoes-formulario">
                <a href="../html_listas/lista_de_produto.php" class="botao botao--secundario">Cancelar</a>
                <button type="submit" class="botao botao--primario">Salvar Alterações</button>
        </div>
        </form>
    </div>
</div>


<script>
$('#foto_produto').change(function() {
    if(this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#foto_produto_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});


</script>  
</body>
</html>