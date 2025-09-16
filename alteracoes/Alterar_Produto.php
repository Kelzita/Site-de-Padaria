<?php 
require_once '../php/funcoes.php';

// Obter o ID do produto da URL
$id_produto = isset($_GET['id']) ? intval($_GET['id']) : 0;

$produto = null;
if($id_produto > 0) {
    $produto = buscarProdutoPorId($id_produto);
}
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
    <img src="../img/logo.png" alt="Logo">
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
                <img src="../php/mostrar_imagem.php?id=<?= $produto['id_produto'] ?>" 
                    alt="Produto" 
                    class="previsualizacao-foto" 
                     id="foto_produto_preview">

            <input type="file" name="foto_produto" id="foto_produto" class="entrada-foto" accept="image/*">
                <label for="foto_produto" class="rotulo-foto">
                <i class="ri-camera-line"></i> Alterar Foto
            </label>
            <p class="instrucoes-foto">Clique no botão para alterar a foto</p>
            </div>
            <!-- DADOS DO PRODUTO -->
            <div class="grupo-formulario">
                <label for="nome_produto" class="rotulo-formulario">Nome do Produto:</label>
                <input type="text" name="nome_produto" id="nome_produto" class="entrada-formulario" value="<?= htmlspecialchars($produto['nome_produto']) ?>" >
            </div>

            <div class="grupo-formulario">
                <label for="descricao" class="rotulo-formulario">Descrição:</label>
                <textarea name="descricao" id="descricao" class="entrada-formulario" ><?= htmlspecialchars($produto['descricao']) ?></textarea>
            </div>

            <div class="grupo-formulario">
                <label for="preco" class="rotulo-formulario">Preço:</label>
                <input type="text" name="preco" id="preco" class="entrada-formulario" placeholder="R$ 0,00"  value="<?= htmlspecialchars($produto['preco']) ?>">
            </div>

            <div class="grupo-formulario">
                <label for="unmedida" class="rotulo-formulario">Unidade de Medida:</label>
                <select name="unmedida" id="unmedida" class="entrada-formulario" >
                    <option value="" disabled <?= empty($produto['unmedida']) ? 'selected' : '' ?>>Selecione...</option>
                    <option value="un" <?= ($produto['unmedida'] ?? '') === 'un' ? 'selected' : '' ?>>Unidade (un)</option>
                    <option value="kg" <?= ($produto['unmedida'] ?? '') === 'kg' ? 'selected' : '' ?>>Quilo (kg)</option>
                    <option value="g" <?= ($produto['unmedida'] ?? '') === 'g' ? 'selected' : '' ?>>Grama (g)</option>
                    <option value="l" <?= ($produto['unmedida'] ?? '') === 'l' ? 'selected' : '' ?>>Litro (L)</option>
                </select>
            </div>

            <div class="grupo-formulario">
                <label for="validade" class="rotulo-formulario">Validade:</label>
                <input type="date" name="validade" id="validade" class="entrada-formulario" value="<?= htmlspecialchars($produto['validade']) ?>" />
            </div>

            <div class="grupo-formulario">
                <label for="quantidade_produto" class="rotulo-formulario">Quantidade:</label>
                <input type="number" name="quantidade_produto" id="quantidade_produto" class="entrada-formulario" value="<?= htmlspecialchars($produto['quantidade_produto']) ?>" />
            </div>

            <div class="grupo-formulario">
                <label for="razao_social" class="rotulo-formulario">Fornecedor:</label>
                <input type="text" name="razao_social" id="razao_social" class="entrada-formulario" value="<?= htmlspecialchars($produto['razao_social']) ?>" />
            </div>

            <div class="acoes-formulario">
                <a href="../html_listas/lista_de_produto.php" class="botao botao--secundario">Cancelar</a>
                <button type="submit" class="botao botao--primario">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
<script src="../javascript/alterar_produto.js"></script>
<!-- JS -->
<script>
    // Máscara para preço
    document.addEventListener("DOMContentLoaded", () => {
        const input = document.getElementById("preco");
        input.addEventListener("input", () => {
            let valor = input.value.replace(/\D/g, "");
            if(valor === "") return input.value = "";
            valor = (valor / 100).toFixed(2) + "";
            valor = valor.replace(".", ",").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            input.value = "R$ " + valor;
        });
    });

    // Pré-visualização
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
