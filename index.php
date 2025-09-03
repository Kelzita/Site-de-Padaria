<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylelogin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap">
    <title>Login</title>
    <style>
        .campo-input {
            position: relative;
            width: 100%;
        }

        .campo-input input {
            width: 100%;
            padding-right: 40px; /* espaço para o olho */
        }

        .toggle-olho {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: #555;
            z-index: 10;
        }

        .toggle-olho:hover {
            color: white;
        }
    </style>
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
                        <!-- Adicionei id="senha" -->
                        <input name="senha" id="senha" type="password" class="style-input" placeholder=" ">
                        <label class="style-label">Senha</label>
                        <!-- Agora chama toggleSenha('senha', this) -->
                        <i class="ri-eye-off-line toggle-olho" onclick="toggleSenha('senha', this)"></i>
                    </div>
                </div>
            </div>
            <div class="link-auxiliar">
                <a href="redefinirsenha.html" class="link-animado">Esqueceu a senha?</a>
            </div>
            <button type="submit" class="botao-style">Login</button>
        </form>
    </div>

    <script>
        function toggleSenha(idCampo, icone) {
            const input = document.getElementById(idCampo);
            if (input.type === "password") {
                input.type = "text";
                icone.classList.remove("ri-eye-off-line");
                icone.classList.add("ri-eye-line");
            } else {
                input.type = "password";
                icone.classList.remove("ri-eye-line");
                icone.classList.add("ri-eye-off-line");
            }
        }
    </script>
</body>
</html>

