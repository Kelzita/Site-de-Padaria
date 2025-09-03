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
</head>
<body>
    <div class="login">
        <form action="php/salvar_nova_senha.php" method="POST" class="formulario-style">
            <h1 class="titulo-style1">Redefinir Senha</h1>
            <div class="conteudo">
                <div class="caixa-style">
                    <i class="ri-lock-2-line login__icon"></i>
                    <div class="campo-input">
                        <input name="nova_senha" type="password" class="style-input" placeholder=" ">
                        <label class="style-label">Nova Senha</label>
                    </div>
                </div>
                <div class="caixa-style">
                    <i class="ri-lock-2-line login__icon"></i>
                    <div class="campo-input">
                        <input name="confirma_senha" type="password" class="style-input" placeholder=" ">
                        <label class="style-label">Confirme a Senha</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="botao-style-redefinir">Redefinir Senha</button>
        </form>
    </div>
</body>
</html>
