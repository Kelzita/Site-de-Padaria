<?php
require_once '../php/conexao.php';
require_once '../php/menu.php';

// Buscar funções para select
try {
    $stmt_funcoes = $pdo->query("SELECT id_funcao, nome_funcao FROM funcao ORDER BY id_funcao");
    $funcoes = $stmt_funcoes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $funcoes = [];
    echo "<script>console.error('Erro ao carregar funções: " . $e->getMessage() . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Funcionário</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/style_cadastro.css" />
    <link rel="stylesheet" href="../css/stylehome.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../javascript/inputmask.min.js"></script>
    <link rel="icon" href="img/logo_title.png">
</head>
<body>

<div class="container">
    <h1>Cadastrar Funcionário</h1>

    <form method="POST" action="../php/cadastro_funcionario.php" class="formulario-cadastro" enctype="multipart/form-data">

        <label for="nome_funcionario"><i class="fas fa-user"></i> Nome:</label>
        <input type="text" id="nome_funcionario" name="nome_funcionario" placeholder="Nome completo">

        <label for="cpf_funcionario"><i class="fas fa-id-card"></i> CPF:</label>
        <input type="text" id="cpf_funcionario" name="cpf_funcionario" placeholder="000.000.000-00" maxlength="14">

        <label for="email_funcionario"><i class="fas fa-envelope"></i> E-mail:</label>
        <input type="email" id="email_funcionario" name="email_funcionario" placeholder="Digite o e-mail">

        <label for="senha"><i class="fas fa-key"></i> Senha:</label>
        <div class="input-container-usuario">
            <input type="password" id="senha" name="senha" placeholder="Insira a senha">
            <i class="ri-eye-off-line login__eye" id="login-eye" onclick="toggleSenha()"></i>
        </div>

        <label for="telefone_funcionario"><i class="fas fa-phone"></i> Telefone:</label>
        <input type="tel" id="telefone_funcionario" name="telefone_funcionario" placeholder="(00) 00000-0000" maxlength="15">

        <label for="cep_funcionario"><i class="fas fa-map-pin"></i> CEP:</label>
        <div class="input-container-cep">
            <input type="text" id="cep_funcionario" name="cep_funcionario" placeholder="00000-000" maxlength="9">
            <i class="ri-search-line busca_lupa" onclick="buscarCEPFuncionario()"></i>
        </div>

        <label for="rua_funcionario"><i class="fas fa-road"></i> Rua:</label>
        <input type="text" id="rua_funcionario" name="rua_funcionario" placeholder="Insira a rua">

        <label for="numero_funcionario"><i class="fas fa-home"></i> Número:</label>
        <input type="number" id="numero_funcionario" name="numero_funcionario" placeholder="Insira o número">

        <label for="bairro_funcionario"><i class="fas fa-city"></i> Bairro:</label>
        <input type="text" id="bairro_funcionario" name="bairro_funcionario" placeholder="Insira o bairro">

        <label for="cidade_funcionario"><i class="fas fa-building"></i> Cidade:</label>
        <input type="text" id="cidade_funcionario" name="cidade_funcionario" placeholder="Insira a cidade">

        <label for="uf_funcionario"><i class="fas fa-flag"></i> UF:</label>
        <select id="uf_funcionario" name="uf_funcionario">
            <option value="" disabled selected>Escolha o Estado</option>
            <?php
            $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
            foreach($ufs as $uf){
                echo "<option value='$uf'>$uf</option>";
            }
            ?>
        </select>

        <label for="data_admissao"><i class="fas fa-calendar-alt"></i> Data de Admissão:</label>
        <input type="date" id="data_admissao" name="data_admissao">

    

        <label for="salario"><i class="fas fa-money-bill-wave"></i> Salário:</label>
        <input type="input" id="salario" name="salario" placeholder="R$0,00">

        <label for="id_funcao"><i class="fas fa-user-cog"></i> Função:</label>
        <select name="id_funcao" id="id_funcao">
            <option value="" disabled selected>Selecione a Função</option>
            <?php foreach ($funcoes as $funcao): ?>
                <option value="<?= $funcao['id_funcao'] ?>"><?= $funcao['id_funcao'] ?> - <?= htmlspecialchars($funcao['nome_funcao']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Cadastrar</button>
    </form>
</div>

<a href='../inicio/home.php' class="voltar"> 
    <img class="seta1" src="../img/btn_voltar.png" title="seta">
    </a>
<script src="../javascript/validacao_func.js"></script>
<script src="../javascript/funcoes.js"></script>
<script>
function toggleSenha() {
    const input = document.getElementById('senha');
    const eye = document.getElementById('login-eye');
    if(input.type === 'password'){
        input.type = 'text';
        eye.classList.remove('ri-eye-off-line');
        eye.classList.add('ri-eye-line');
    } else {
        input.type = 'password';
        eye.classList.remove('ri-eye-line');
        eye.classList.add('ri-eye-off-line');
    }
}


</script>
</body>
</html>
