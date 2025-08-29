<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap">
    <link rel="stylesheet" href="css/stylelogin.css">
    <title>Login</title>
</head>
<body>
    <body>
        <div class="login">
          <form action="php/login.php" method="POST" class="formulario-style">
            <h1 class="titulo-style">Login</h1>
            <div class="conteudo">
              <div class="caixa-style">
                <i class="ri-user-3-line login__icon"></i>
                <div class="campo-input">
                  <input name="email_funcionario" type="text" class="style-input" id="email_funcionario" placeholder=" ">
                  <label for="email_funcionario" class="style-label">Email:</label>
                </div>
              </div>
      
              <div class="caixa-style">
                <i class="ri-lock-2-line login__icon"></i>
                <div class="campo-input">
                  <i class="ri-eye-off-line login__eye" id="login-eye" onclick="toggleSenha()"></i>
                  <input name="senha" type="password" class="style-input" id="senha" placeholder=" ">
                  <label for="senha" class="style-label">Senha</label>
                </div>
              </div>
            </div>
      
            <div class="link-auxiliar">
              <a href="redefinirsenha.html" class="esqueci-senha-style">Esqueceu a senha?</a>
            </div>
            <button type="submit" class="botao-style">Login</button>
          </form>
        </div>
</body>
<!--<script src="js/togglesenha.js"></script>-->

</html>