<?php 
require_once '../php/funcoes.php';

// Obter o ID do fornecedor da URL
$id_fornecedor = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Buscar os dados do fornecedor
$fornecedor = null;
if ($id_fornecedor > 0) {
    $fornecedor = buscarFornecedorPorId($id_fornecedor);
}

// Se não encontrar o fornecedor, redirecionar
if (!$fornecedor) {
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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css"/>
    <link rel="stylesheet" href="../css/alterar.css"/>
</head>
<body>

<header>
    <img src="../img/logo.png">
</header>

<div class="modal-editar">
    <div class="modal-editar__container">
        <div class="modal-editar__header">
            <h2 class="modal-editar__titulo">Editar Fornecedor</h2>
            <a href="../html_listas/lista_de_fornecedores.php" class="modal-editar__fechar">&times;</a>
        </div>
        
        <form id="formulario-editar-fornecedor" class="formulario" action="../php/alterar_fornecedor.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_fornecedor" value="<?= $fornecedor['id_fornecedor'] ?>">

            <!-- Dados do Fornecedor -->
            <div class="grupo-formulario">
                <label for="razao_social" class="rotulo-formulario">Razão Social:</label>
                <input type="text" name="razao_social" id="razao_social" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['razao_social']) ?>" required>
            </div>

            <div class="grupo-formulario">
                <label for="responsavel" class="rotulo-formulario">Responsável:</label>
                <input type="text" name="responsavel" id="responsavel" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['responsavel']) ?>" required>
            </div>

            <div class="grupo-formulario">
                <label for="cnpj_fornecedor" class="rotulo-formulario">CNPJ:</label>
                <input type="text" name="cnpj_fornecedor" id="cnpj_fornecedor" class="entrada-formulario" maxlength="18" value="<?= htmlspecialchars($fornecedor['cnpj_fornecedor']) ?>" required>
            </div>

            <div class="grupo-formulario">
                <label for="email_fornecedor" class="rotulo-formulario">E-mail:</label>
                <input type="email" name="email_fornecedor" id="email_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['email_fornecedor']) ?>" required>
            </div>

            <div class="grupo-formulario">
                <label for="telefone_fornecedor" class="rotulo-formulario">Telefone:</label>
                <input type="text" name="telefone_fornecedor" id="telefone_fornecedor" class="entrada-formulario" maxlength="15" value="<?= htmlspecialchars($fornecedor['telefone_fornecedor']) ?>">
            </div>

            <!-- Endereço -->
            <div class="grupo-formulario grupo-formulario--completo">
                <h3 style="margin: 1.5rem 0 1rem; color: #444; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">Endereço</h3>
            </div>

            <div class="grupo-formulario">
                <label for="cep_fornecedor" class="rotulo-formulario">CEP:</label>
                <div class="entrada-com-icone">
                    <input type="text" name="cep_fornecedor" id="cep_fornecedor" class="entrada-formulario entrada-formulario--cep" maxlength="10" placeholder="00000-000" value="<?= htmlspecialchars($fornecedor['cep_fornecedor']) ?>">
                    <i class="ri-search-line icone-entrada" id="buscar-cep"></i>
                    <div class="carregando" id="carregando-cep"></div>
                </div>
            </div>

            <div class="grupo-formulario">
                <label for="rua_fornecedor" class="rotulo-formulario">Rua:</label>
                <input type="text" name="rua_fornecedor" id="rua_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['rua_fornecedor']) ?>">
            </div>

            <div class="grupo-formulario">
                <label for="numero_fornecedor" class="rotulo-formulario">Número:</label>
                <input type="text" name="numero_fornecedor" id="numero_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['numero_fornecedor']) ?>">
            </div>

            <div class="grupo-formulario">
                <label for="bairro_fornecedor" class="rotulo-formulario">Bairro:</label>
                <input type="text" name="bairro_fornecedor" id="bairro_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['bairro_fornecedor']) ?>">
            </div>

            <div class="grupo-formulario">
                <label for="cidade_fornecedor" class="rotulo-formulario">Cidade:</label>
                <input type="text" name="cidade_fornecedor" id="cidade_fornecedor" class="entrada-formulario" value="<?= htmlspecialchars($fornecedor['cidade_fornecedor']) ?>">
            </div>

            <div class="grupo-formulario">
                <label for="uf_fornecedor" class="rotulo-formulario">UF:</label>
                <select name="uf_fornecedor" id="uf_fornecedor" class="selecao-formulario">
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

<script>
$(document).ready(function() {
    // Máscaras
    Inputmask({"mask": "(99) 99999-9999", "placeholder": ""}).mask("#telefone_fornecedor");
    Inputmask({"mask": "999.999.999-99", "placeholder": ""}).mask("#cnpj_fornecedor");
    Inputmask({"mask": "99999-999", "placeholder": ""}).mask("#cep_fornecedor");

    // Preview da imagem
    $('#foto_fornecedor').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#foto_fornecedor_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Buscar CEP
    $('#buscar-cep').click(buscarCEP);
    $('#cep_fornecedor').blur(buscarCEP);

    function buscarCEP() {
        var cep = $('#cep_fornecedor').val().replace(/\D/g, '');
        if (cep.length === 8) {
            $('#carregando-cep').show();
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(dados) {
                if (!("erro" in dados)) {
                    $('#rua_fornecedor').val(dados.logradouro);
                    $('#bairro_fornecedor').val(dados.bairro);
                    $('#cidade_fornecedor').val(dados.localidade);
                    $('#uf_fornecedor').val(dados.uf);
                } else {
                    alert('CEP não encontrado.');
                }
                $('#carregando-cep').hide();
            }).fail(function() {
                alert('Erro ao buscar CEP.');
                $('#carregando-cep').hide();
            });
        }
    }
});
</script>
</body>
</html>
