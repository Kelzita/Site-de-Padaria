<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylelogin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap">
    <title>Login</title>
</head>
<body>
    <div class="login">
        <form action="php/login.php" method="POST" class="formulario-style">
            <h1 class="titulo-style">Login</h1>
            <div class="conteudo">
                <div class="caixa-style">
                    <i class="ri-user-3-line login__icon"></i>
                    <div class="campo-input">
                        <input name="email_funcionario" type="text" class="style-input" placeholder=" ">
                        <label class="style-label">Email:</label>
                    </div>
                </div>
                <div class="caixa-style">
                    <i class="ri-lock-2-line login__icon"></i>
                    <div class="campo-input">
                        <input name="senha" type="password" class="style-input" placeholder=" ">
                        <label class="style-label">Senha</label>
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
</html>
