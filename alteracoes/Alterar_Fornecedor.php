<?php 
require_once '../php/funcoes.php';

$id_fornecedor = isset($_GET['id']) ? intval($_GET['id']) : 0;
$fornecedor = buscarFornecedorPorId($id_fornecedor);

if(!$fornecedor){
    header('Location: ../html_listas/lista_de_fornecedores.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Fornecedor</title>
<link rel="stylesheet" href="../css/styles.css"/>
<link rel="stylesheet" href="../css/alterar.css"/>
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
</head>
<body>
<header><img src="../img/logo.png" alt="Logo"></header>

<div class="modal-editar">
    <div class="modal-editar__container">
        <div class="modal-editar__header">
            <h2 class="modal-editar__titulo">Editar Fornecedor</h2>
            <a href="../html_listas/lista_de_fornecedores.php" class="modal-editar__fechar">&times;</a>
        </div>

        <form id="formulario-editar-fornecedor" class="formulario" action="../php/alterar_fornecedor.php" method="POST">
            <input type="hidden" name="id_fornecedor" value="<?= $fornecedor['id_fornecedor'] ?>">

            <!-- Dados do Fornecedor -->
            <div class="grupo-formulario">
                <label class="rotulo-formulario">Razão Social:</label>
                <input type="text" name="razao_social" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['razao_social']) ?>" >
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Responsável:</label>
                <input type="text" name="responsavel" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['responsavel']) ?>" >
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">CNPJ:</label>
                <input type="text" name="cnpj_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['cnpj_fornecedor']) ?>" >
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Email:</label>
                <input type="email" name="email_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['email_fornecedor']) ?>" >
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Telefone:</label>
                <input type="text" name="telefone_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['telefone_fornecedor']) ?>">
            </div>

            <!-- Endereço -->
            <div class="grupo-formulario grupo-formulario--completo">
                <h3 style="margin:1.5rem 0 1rem; color:#444; border-bottom:1px solid #eee; padding-bottom:0.5rem;">Endereço</h3>
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">CEP:</label>
                <input type="text" name="cep_fornecedor" class="entrada-formulario entrada-formulario--cep" value="<?= htmlspecialchars($fornecedor['cep_fornecedor']) ?>">
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Rua:</label>
                <input type="text" name="rua_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['rua_fornecedor']) ?>">
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Número:</label>
                <input type="text" name="numero_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['numero_fornecedor']) ?>">
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Bairro:</label>
                <input type="text" name="bairro_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['bairro_fornecedor']) ?>">
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">Cidade:</label>
                <input type="text" name="cidade_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['cidade_fornecedor']) ?>">
            </div>

            <div class="grupo-formulario">
                <label class="rotulo-formulario">UF:</label>
                <select name="uf_fornecedor" class="selecao-formulario">
                    <option value="">Selecione o estado</option>
                    <?php 
                    $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
                    foreach($ufs as $uf):
                    ?>
                        <option value="<?= $uf ?>" <?= $fornecedor['uf_fornecedor'] == $uf ? 'selected' : '' ?>><?= $uf ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="acoes-formulario">
                <a href="../html_listas/lista_de_fornecedores.php" class="botao botao--secundario">Cancelar</a>
                <button type="submit" class="botao botao--primario">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
<script src="../javascript/alterar_fornecedor.js"></script>
<script>
$(document).ready(function(){
    Inputmask({"mask": "(99) 99999-9999"}).mask("input[name='telefone_fornecedor']");
    Inputmask({"mask": "99.999.999/9999-99"}).mask("input[name='cnpj_fornecedor']");
    Inputmask({"mask": "99999-999"}).mask("input[name='cep_fornecedor']");
});
</script>
</body>
</html>