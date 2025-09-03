<?php
session_start();
if (!isset($_SESSION['id_funcionario'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="css/stylelogin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
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
            z-index: 10; /* garante que o clique funcione */
        }

        .toggle-olho:hover {
            color: white;
        }
    </style>
</head>
<body>
    <div class="login">
        <form action="php/salvar_nova_senha.php" method="POST" class="formulario-style">
            <h1 class="titulo-style1">Redefinir Senha</h1>
            <div class="conteudo">
                <div class="caixa-style">
                    <i class="ri-lock-2-line login__icon"></i>
                    <div class="campo-input">
                        <input name="nova_senha" id="nova_senha" type="password" class="style-input" placeholder=" ">
                        <label class="style-label">Nova Senha</label>
                        <i class="ri-eye-off-line toggle-olho" onclick="toggleSenha('nova_senha', this)"></i>
                    </div>
                </div>
                <div class="caixa-style">
                    <i class="ri-lock-2-line login__icon"></i>
                    <div class="campo-input">
                        <input name="confirma_senha" id="confirma_senha" type="password" class="style-input" placeholder=" ">
                        <label class="style-label">Confirme a Senha</label>
                        <i class="ri-eye-off-line toggle-olho" onclick="toggleSenha('confirma_senha', this)"></i>
                    </div>
                </div>
            </div>
            <button type="submit" class="botao-style-redefinir">Redefinir Senha</button>
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