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
    <script src="../javascript/inputmask.min.js"></script>
    </head>
    <body>
    <header>
        <img src="../img/logo.png" alt="Logo">
        <!--Menu-->
    </header>
    <div class="container-usuario">
        <h1>Cadastrar Usuário</h1>
   
        <form class="formulario-cadastro-usuario" action="../php/cadastro_usuario.php" method="POST">
            <label for="nome_usuario">Usuário</label>
            <input type="text" name="nome_usuario" id="nome_usuario" placeholder="Insira um nome de usuário"/>
            
            <label for="senha">Senha</label>
            <div class="input-container-usuario">
                <input type="password" name="senha" id="senha" placeholder="Insira a senha"/>
                <i class="ri-eye-off-line login__eye" id="login-eye" onclick="toggleSenha()"></i>
            </div> 
            <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Cadastrar</button> 
        </form>
    </div>

    <script src="../js/validacao_cad_funcionario.js"></script>
    <script src="../javascript/funcoes.js" ></script>
</body>
</html>
