<?php
// Cria a conexão
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verifica se houve erro
if (!$conexao) {
  die("Falha na conexão: " . mysqli_connect_error());
}

// Dados do usuário
$login = "Novo Usuario";
$email = "novousuario@example.com";
$senha = "senha123";

// Comando SQL para inserir um novo usuário
$sql = "INSERT INTO usuario (login, email, senha) VALUES ('$login', '$email', '$senha')";

// Executando o comando SQL
if (mysqli_query($conexao, $sql)) {
  echo "Novo usuário inserido com sucesso!";
} else {
  echo "Erro ao inserir usuário: " . mysqli_error($conexao);
}

// Fecha a conexão
mysqli_close($conexao);
?>
