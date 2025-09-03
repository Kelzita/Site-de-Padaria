<?php 
require_once '../php/funcoes.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/alterar.css">
  
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <header>
        <img src="../img/logo.png">
    </header>

<div class="modal-editar">
    <div class="modal-editar__container">
        <div class="modal-editar__header">
            <h2 class="modal-editar__titulo">Editar Funcionário</h2>
            <span class="modal-editar__fechar">&times;</span>
        </div>
        
        <form id="formulario-editar-funcionario" class="formulario-funcionario" action="../php/alterar_funcionario.php" method="POST" enctype="multipart/form-data">
            <div class="grupo-formulario grupo-formulario--completo">
                <div class="container-foto">
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgPGNpcmNsZSBjeD0iNjAiIGN5PSI2MCIgcj0iNjAiIGZpbGw9IiNFMEUwRTAiLz4KICA8Y2lyY2xlIGN4PSI2MCIgY3k9IjQ1IiByPSIyMCIgZmlsbD0iI0JBQkFCQSIvPgogIDxwYXRoIGQ9Ik0yMCAxMDBDNDAgNzUgODAgNzUgMTAwIDEwMEgyMFoiIGZpbGw9IiNCQUJBQkEiLz4KPC9zdmc+" alt="Preview" class="previsualizacao-foto" id="foto_funcionario_preview">
                    <input type="file" name="foto_funcionario" id="foto_funcionario" class="entrada-foto" accept="image/*">
                    <label for="foto_funcionario" class="rotulo-foto">
                        <i class="ri-camera-line"></i> Alterar Foto
                    </label>
                    <p class="instrucoes-foto">Clique na imagem ou no botão para alterar a foto</p>
                    <input type="hidden" name="foto_atual" id="foto_atual">
                </div>
            </div>

            <!-- Dados Pessoais -->
            <div class="grupo-formulario">
                <label for="nome_funcionario" class="rotulo-formulario">Nome:</label>
                <input type="text" name="nome_funcionario" id="nome_funcionario" class="entrada-formulario" required>
            </div>
            
            <div class="grupo-formulario">
                <label for="cpf_funcionario" class="rotulo-formulario">CPF:</label>
                <input type="text" name="cpf_funcionario" id="cpf_funcionario" class="entrada-formulario" maxlength="14" required>
            </div>
            
            <div class="grupo-formulario">
                <label for="email_funcionario" class="rotulo-formulario">E-mail:</label>
                <input type="email" name="email_funcionario" id="email_funcionario" class="entrada-formulario" required>
            </div>
            
            <div class="grupo-formulario">
                <label for="telefone_funcionario" class="rotulo-formulario">Telefone:</label>
                <input type="text" name="telefone_funcionario" id="telefone_funcionario" class="entrada-formulario" maxlength="15">
            </div>
            
            <div class="grupo-formulario">
                <label for="senha" class="rotulo-formulario">Senha:</label>
                <input type="password" name="senha" id="senha" class="entrada-formulario" placeholder="Deixe em branco para manter a atual">
            </div>
            
            <div class="grupo-formulario">
                <label for="data_admissao" class="rotulo-formulario">Data de Admissão:</label>
                <input type="date" name="data_admissao" id="data_admissao" class="entrada-formulario">
            </div>
            
            <div class="grupo-formulario">
                <label for="salario" class="rotulo-formulario">Salário:</label>
                <input type="number" name="salario" id="salario" class="entrada-formulario" step="0.01" min="0">
            </div>
            
            <div class="grupo-formulario">
                <label for="id_funcao" class="rotulo-formulario">Função:</label>
                <select name="id_funcao" id="id_funcao" class="selecao-formulario" required>
                    <option selected disabled>Selecione a Função</option>
                    <?php foreach ($funcoes as $funcao): ?>
                    <option value="<?= htmlspecialchars($funcao['id_funcao']) ?>" <?=$funcao['id_funcao']==$idSelecionado ? 'selected' : '' ?>>
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
                    <input type="text" name="cep_funcionario" id="cep_funcionario" class="entrada-formulario entrada-formulario--cep" maxlength="9" placeholder="00000-000">
                    <i class="ri-search-line icone-entrada" id="buscar-cep"></i>
                    <div class="carregando" id="carregando-cep"></div>
                </div>
            </div>
            
            <div class="grupo-formulario">
                <label for="rua_funcionario" class="rotulo-formulario">Rua:</label>
                <input type="text" name="rua_funcionario" id="rua_funcionario" class="entrada-formulario">
            </div>
            
            <div class="grupo-formulario">
                <label for="numero_funcionario" class="rotulo-formulario">Número:</label>
                <input type="text" name="numero_funcionario" id="numero_funcionario" class="entrada-formulario">
            </div>
            
            <div class="grupo-formulario">
                <label for="bairro_funcionario" class="rotulo-formulario">Bairro:</label>
                <input type="text" name="bairro_funcionario" id="bairro_funcionario" class="entrada-formulario">
            </div>
            
            <div class="grupo-formulario">
                <label for="cidade_funcionario" class="rotulo-formulario">Cidade:</label>
                <input type="text" name="cidade_funcionario" id="cidade_funcionario" class="entrada-formulario">
            </div>
            
            <div class="grupo-formulario">
                <label for="uf_funcionario" class="rotulo-formulario">UF:</label>
                <select name="uf_funcionario" id="uf_funcionario" class="selecao-formulario">
                    <option value="">Selecione o estado</option>
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
            </div>
            
            <div class="acoes-formulario">
                <button type="button" class="botao botao--secundario">Cancelar</button>
                <button type="submit" class="botao botao--primario">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<script src="../javascript/funcoesalterar.js"></script>

</body>
</html>