<?php 
require_once '../php/funcoes.php';

// Obter o ID do funcionário da URL
$id_funcionario = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Buscar os dados do funcionário
$funcionario = null;
if ($id_funcionario > 0) {
    $funcionario = buscarFuncionarioPorId($id_funcionario);
}

// Se não encontrar o funcionário, redirecionar
if (!$funcionario) {
    header('Location: ../html_listas/lista_de_funcionarios.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Projeto</title>
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
            <h2 class="modal-editar__titulo">Editar Funcionário</h2>
            <a href="../html_listas/lista_de_funcionarios.php" class="modal-editar__fechar">&times;</a>
        </div>
        
        <form id="formulario-editar-funcionario" class="formulario" action="../php/alterar_funcionario.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_funcionario" value="<?= $funcionario['id_funcionario'] ?>">
            
            <div class="grupo-formulario grupo-formulario--completo">
                <div class="container-foto">
                    <?php if (!empty($funcionario['imagem_funcionario'])): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($funcionario['imagem_funcionario']) ?>" alt="Foto do funcionário" class="previsualizacao-foto" id="foto_funcionario_preview">
                    <?php else: ?>
                        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgPGNpcmNsZSBjeD0iNjAiIGN5PSI2MCIgcj0iNjAiIGZpbGw9IiNFMEUwRTAiLz4KICA8Y2lyY2xlIGN4PSI2MCIgY3k9IjQ1IiByPSIyMCIgZmlsbD0iI0JBQkFCQSIvPgogIDxwYXRoIGQ9Ik0yMCAxMDBDNDAgNzUgODAgNzUgMTAwIDEwMEgyMFoiIGZpbGw9IiNCQUJBQkEiLz4KPC9zdmc+" alt="Preview" class="previsualizacao-foto" id="foto_funcionario_preview">
                    <?php endif; ?>
                    <input type="file" name="foto_funcionario" id="foto_funcionario" class="entrada-foto" accept="image/*">
                    <label for="foto_funcionario" class="rotulo-foto">
                        <i class="ri-camera-line"></i> Alterar Foto
                    </label>
                    <p class="instrucoes-foto">Clique no botão para alterar a foto</p>
                    <input type="hidden" name="foto_atual" id="foto_atual" value="<?= !empty($funcionario['imagem_funcionario']) ? base64_encode($funcionario['imagem_funcionario']) : '' ?>">
                </div>
            </div>

            <!-- Dados Pessoais -->
            <div class="grupo-formulario">
                <label for="nome_funcionario" class="rotulo-formulario">Nome:</label>
                <input type="text" name="nome_funcionario" id="nome_funcionario" class="entrada-formulario" value="<?= htmlspecialchars($funcionario['nome_funcionario']) ?>" required>
            </div>
            
            <div class="grupo-formulario">
                <label for="cpf_funcionario" class="rotulo-formulario">CPF:</label>
                <input type="text" name="cpf_funcionario" id="cpf_funcionario" class="entrada-formulario" maxlength="16" value="<?= htmlspecialchars($funcionario['cpf_funcionario']) ?>" required>
            </div>
            
            <div class="grupo-formulario">
                <label for="email_funcionario" class="rotulo-formulario">E-mail:</label>
                <input type="email" name="email_funcionario" id="email_funcionario" class="entrada-formulario" value="<?= htmlspecialchars($funcionario['email_funcionario']) ?>" required>
            </div>
            
            <div class="grupo-formulario">
                <label for="telefone_funcionario" class="rotulo-formulario">Telefone:</label>
                <input type="text" name="telefone_funcionario" id="telefone_funcionario" class="entrada-formulario" maxlength="15" value="<?= htmlspecialchars($funcionario['telefone_funcionario']) ?>">
            </div>
            
            <div class="grupo-formulario">
                <label for="senha" class="rotulo-formulario">Senha:</label>
                <input type="password" name="senha" id="senha" class="entrada-formulario" placeholder="Deixe em branco para manter a atual">
            </div>
            
            <div class="grupo-formulario">
                <label for="data_admissao" class="rotulo-formulario">Data de Admissão:</label>
                <input type="date" name="data_admissao" id="data_admissao" class="entrada-formulario" value="<?= htmlspecialchars($funcionario['data_admissao']) ?>">
            </div>
            
            <div class="grupo-formulario">
                <label for="salario" class="rotulo-formulario">Salário:</label>
                <input type="number" name="salario" id="salario" class="entrada-formulario" step="0.01" min="0" value="<?= htmlspecialchars($funcionario['salario']) ?>">
            </div>
            
            <div class="grupo-formulario">
                <label for="id_funcao" class="rotulo-formulario">Função:</label>
                <select name="id_funcao" id="id_funcao" class="selecao-formulario" required>
                    <option disabled>Selecione a Função</option>
                    <?php foreach ($funcoes as $funcao): ?>
                    <option value="<?= htmlspecialchars($funcao['id_funcao']) ?>" <?= $funcao['id_funcao'] == $funcionario['id_funcao'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($funcao['id_funcao'] . ' - ' . $funcao['nome_funcao']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Endereço -->
            <div class="grupo-formulario grupo-formulario--completo">
                <h3 style="margin: 1.5rem 0 1rem; color: #444; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">Endereço</h3>
            </div>
            
            <div class="grupo-formulario">
                <label for="cep_funcionario" class="rotulo-formulario">CEP:</label>
                <div class="entrada-com-icone">
                    <input type="text" name="cep_funcionario" id="cep_funcionario" class="entrada-formulario entrada-formulario--cep" maxlength="10" placeholder="00000-000" value="<?= htmlspecialchars($funcionario['cep_funcionario']) ?>">
                    <i class="ri-search-line icone-entrada" id="buscar-cep"></i>
                    <div class="carregando" id="carregando-cep"></div>
                </div>
            </div>
            
            <div class="grupo-formulario">
                <label for="rua_funcionario" class="rotulo-formulario">Rua:</label>
                <input type="text" name="rua_funcionario" id="rua_funcionario" class="entrada-formulario" value="<?= htmlspecialchars($funcionario['rua_funcionario']) ?>">
            </div>
            
            <div class="grupo-formulario">
                <label for="numero_funcionario" class="rotulo-formulario">Número:</label>
                <input type="text" name="numero_funcionario" id="numero_funcionario" class="entrada-formulario" value="<?= htmlspecialchars($funcionario['numero_funcionario']) ?>">
            </div>
            
            <div class="grupo-formulario">
                <label for="bairro_funcionario" class="rotulo-formulario">Bairro:</label>
                <input type="text" name="bairro_funcionario" id="bairro_funcionario" class="entrada-formulario" value="<?= htmlspecialchars($funcionario['bairro_funcionario']) ?>">
            </div>
            
            <div class="grupo-formulario">
                <label for="cidade_funcionario" class="rotulo-formulario">Cidade:</label>
                <input type="text" name="cidade_funcionario" id="cidade_funcionario" class="entrada-formulario" value="<?= htmlspecialchars($funcionario['cidade_funcionario']) ?>">
            </div>
            
            <div class="grupo-formulario">
                <label for="uf_funcionario" class="rotulo-formulario">UF:</label>
                <select name="uf_funcionario" id="uf_funcionario" class="selecao-formulario">
                    <option value="">Selecione o estado</option>
                    <option value="AC" <?= $funcionario['uf_funcionario'] == 'AC' ? 'selected' : '' ?>>Acre</option>
                    <option value="AL" <?= $funcionario['uf_funcionario'] == 'AL' ? 'selected' : '' ?>>Alagoas</option>
                    <option value="AP" <?= $funcionario['uf_funcionario'] == 'AP' ? 'selected' : '' ?>>Amapá</option>
                    <option value="AM" <?= $funcionario['uf_funcionario'] == 'AM' ? 'selected' : '' ?>>Amazonas</option>
                    <option value="BA" <?= $funcionario['uf_funcionario'] == 'BA' ? 'selected' : '' ?>>Bahia</option>
                    <option value="CE" <?= $funcionario['uf_funcionario'] == 'CE' ? 'selected' : '' ?>>Ceará</option>
                    <option value="DF" <?= $funcionario['uf_funcionario'] == 'DF' ? 'selected' : '' ?>>Distrito Federal</option>
                    <option value="ES" <?= $funcionario['uf_funcionario'] == 'ES' ? 'selected' : '' ?>>Espírito Santo</option>
                    <option value="GO" <?= $funcionario['uf_funcionario'] == 'GO' ? 'selected' : '' ?>>Goiás</option>
                    <option value="MA" <?= $funcionario['uf_funcionario'] == 'MA' ? 'selected' : '' ?>>Maranhão</option>
                    <option value="MT" <?= $funcionario['uf_funcionario'] == 'MT' ? 'selected' : '' ?>>Mato Grosso</option>
                    <option value="MS" <?= $funcionario['uf_funcionario'] == 'MS' ? 'selected' : '' ?>>Mato Grosso do Sul</option>
                    <option value="MG" <?= $funcionario['uf_funcionario'] == 'MG' ? 'selected' : '' ?>>Minas Gerais</option>
                    <option value="PA" <?= $funcionario['uf_funcionario'] == 'PA' ? 'selected' : '' ?>>Pará</option>
                    <option value="PB" <?= $funcionario['uf_funcionario'] == 'PB' ? 'selected' : '' ?>>Paraíba</option>
                    <option value="PR" <?= $funcionario['uf_funcionario'] == 'PR' ? 'selected' : '' ?>>Paraná</option>
                    <option value="PE" <?= $funcionario['uf_funcionario'] == 'PE' ? 'selected' : '' ?>>Pernambuco</option>
                    <option value="PI" <?= $funcionario['uf_funcionario'] == 'PI' ? 'selected' : '' ?>>Piauí</option>
                    <option value="RJ" <?= $funcionario['uf_funcionario'] == 'RJ' ? 'selected' : '' ?>>Rio de Janeiro</option>
                    <option value="RN" <?= $funcionario['uf_funcionario'] == 'RN' ? 'selected' : '' ?>>Rio Grande do Norte</option>
                    <option value="RS" <?= $funcionario['uf_funcionario'] == 'RS' ? 'selected' : '' ?>>Rio Grande do Sul</option>
                    <option value="RO" <?= $funcionario['uf_funcionario'] == 'RO' ? 'selected' : '' ?>>Rondônia</option>
                    <option value="RR" <?= $funcionario['uf_funcionario'] == 'RR' ? 'selected' : '' ?>>Roraima</option>
                    <option value="SC" <?= $funcionario['uf_funcionario'] == 'SC' ? 'selected' : '' ?>>Santa Catarina</option>
                    <option value="SP" <?= $funcionario['uf_funcionario'] == 'SP' ? 'selected' : '' ?>>São Paulo</option>
                    <option value="SE" <?= $funcionario['uf_funcionario'] == 'SE' ? 'selected' : '' ?>>Sergipe</option>
                    <option value="TO" <?= $funcionario['uf_funcionario'] == 'TO' ? 'selected' : '' ?>>Tocantins</option>
                </select>
            </div>
            
            <div class="acoes-formulario">
                <a href="../html_listas/lista_de_funcionarios.php" class="botao botao--secundario">Cancelar</a>
                <button type="submit" class="botao botao--primario">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Aplicar máscaras aos campos
    Inputmask({"mask": "(99) 99999-9999", "placeholder": "", showMaskOnHover: false, showMaskOnFocus: false})
        .mask("#telefone_funcionario, #telefone_fornecedor");

    Inputmask({"mask": "999.999.999-99", "placeholder": "", showMaskOnHover: false, showMaskOnFocus: false})
        .mask("#cpf_funcionario");

    Inputmask({"mask": "99.999.999/9999-99", "placeholder": "", showMaskOnHover: false, showMaskOnFocus: false})
        .mask("#cnpj_fornecedor");

    Inputmask({"mask": "99999-999", "placeholder": "", showMaskOnHover: false, showMaskOnFocus: false})
        .mask("#cep_funcionario, #cep_fornecedor");

    // Preview da imagem
    $('#foto_funcionario').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#foto_funcionario_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Buscar CEP
    $('#buscar-cep').click(function() {
        buscarCEP();
    });
    
    $('#cep_funcionario').blur(function() {
        buscarCEP();
    });
    
    function buscarCEP() {
        var cep = $('#cep_funcionario').val().replace(/\D/g, '');
        if (cep.length === 8) {
            $('#carregando-cep').show();
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(dados) {
                if (!("erro" in dados)) {
                    $('#rua_funcionario').val(dados.logradouro);
                    $('#bairro_funcionario').val(dados.bairro);
                    $('#cidade_funcionario').val(dados.localidade);
                    $('#uf_funcionario').val(dados.uf);
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