<?php 
include_once '../php/menu.php';

?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Bem-vindo(a) <?php echo $_SESSION['nome_funcionario']; ?> <?php echo '<br>Função: ' .$nome_funcao; ?></h1>
    <form action="../php/logout.php" method="POST">
    <button type="submit" >logout<logout>
   </form>
</body>
</html>