<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
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
        <h1>Cadastrar Funcionário</h1>
        <form class="formulario-cadastro" method="POST" action="../php/funcionario.php" onsubmit="return ValidacaoFornecedor(event)">

            <label for="nome_funcionario"><i class="fas fa-user"></i> Nome:</label>
            <input type="text" id="nome_funcionario" name="nome_funcionario" placeholder="Nome completo" >

            <label for="cpf_funcionario"><i class="fas fa-id-card"></i> CPF:</label>
            <input type="text" id="cpf_funcionario" name="cpf_funcionario" placeholder="Digite o CPF" maxlength="14" >

            <label for="email_funcionario"><i class="fas fa-envelope"></i> E-mail:</label>
            <input type="email" id="email_funcionario" name="email_funcionario" placeholder="Digite o e-mail" >

            <label for="telefone_funcionario"><i class="fas fa-phone"></i> Telefone:</label>
            <input type="tel" id="telefone_funcionario" name="telefone_funcionario" placeholder="(00) 00000-0000" maxlength="15" pattern="\(\d{2}\) \d{4,5}-\d{4}" title="Formato: (00) 00000-0000" >

            <label for="cep_funcionario"><i class="fas fa-map-pin"></i> CEP:</label>
            <input type="text" id="cep_funcionario" name="cep_funcionario" placeholder="Digite o CEP" maxlength="9" oninput="formatCEP(this)" onblur="buscarCEP(this.value)" >
    

            <label for="rua_funcionario"><i class="fas fa-road"></i> Rua:</label>
            <input type="text" id="rua_funcionario" name="rua_funcionario" placeholder="Insira a rua" >

            <label for="numero_funcionario"><i class="fas fa-home"></i> Número:</label>
            <input type="number" id="numero_funcionario" name="numero_funcionario" placeholder="insira o número" >

            <label for="bairro_funcionario"><i class="fas fa-city"></i> Bairro:</label>
            <input type="text" id="bairro_funcionario" name="bairro_funcionario" placeholder="Insira o bairro" >

            <label for="cidade_funcionario"><i class="fas fa-building"></i> Cidade:</label>
            <input type="text" id="cidade_funcionario" name="cidade_funcionario" placeholder="Insira a cidade" >

            <label for="uf"><i class="fas fa-flag"></i> UF:</label>
            <select id="uf_funcionario" name="uf_funcionario" >
                <option value="" selected disabled>Escolha o Estado</option>
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

            <label for="data_admissao"><i class="fas fa-calendar-alt"></i> Data de Admissão:</label>
            <input type="date" id="data_admissao" name="data_admissao" >

            <label for="salario"><i class="fas fa-money-bill-wave"></i> Salário:</label>
            <input type="number" step="0.01" id="salario" name="salario" placeholder="R$ 0,00" >

            <label for="id_funcao"><i class="fas fa-user-cog"></i> Função:</label>
            <select id="id_funcao" name="id_funcao" >
                <option selected disabled>Selecione a Função</option>
                <option value="<?=htmlspecialchars($funcao['id_funcao']) == 1 ? 'select ' : ''?>">Administrador</option>
                <option value="<?=htmlspecialchars($funcao['id_funcao']) == 1 ? 'select ' : ''?>">Gestor de Estoque</option>
                <option value="<?=htmlspecialchars($funcao['id_funcao']) == 1 ? 'select ' : ''?>">Balconista</option>
                <option value="<?=htmlspecialchars($funcao['id_funcao']) == 1 ? 'select ' : ''?>">Caixa</option>
            </select>

            <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Cadastrar</button>
        </form>
        <form class="formulario-cadastro" action="../php/cadastro_usuario.php" method="POST">
            <label for="nome_usuario">Usuário</label>
            <input type="text" name="nome_usuario" id="nome_usuario" placeholder="Insira um nome de usuário"/>
            <label for="senha">Senha</label>
            <i class="ri-eye-off-line login__eye" id="login-eye" onclick="toggleSenha()"></i>
            <input type="text" name="senha" id="senha" placeholder="Insira a senha"/>
            
    </form>
    </div>
    <script src="../js/validacao_cad_funcionario.js"></script>
    <script> 
    function toggleSenha() {
        const inputSenha = document.getElementById("senha");
        const botao = document.getElementById("login-eye");

        if (inputSenha.type === "password") {
            inputSenha.type = "text";
            botao.classList.remove("ri-eye-off-line");
            botao.classList.add("ri-eye-line");
        } else {
            inputSenha.type = "password";
            botao.classList.remove("ri-eye-line");
            botao.classList.add("ri-eye-off-line");
        }
    }
    </script>
</body>
</html>
