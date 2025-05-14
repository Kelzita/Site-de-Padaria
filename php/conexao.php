<?php
$servidor = "localhost";
$usuario = "root"; // padrão do XAMPP
$senha = "root";    // padrão do XAMPP
$banco = "padaria_pao_genial"; // nome do seu banco

// Cria a conexão
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verifica se houve erro
if (!$conexao) {
  die("Falha na conexão: " . mysqli_connect_error());
}

echo "Conexão bem-sucedida com o banco de dados!";
?>
