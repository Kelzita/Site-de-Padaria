<?php
// Configurações do banco de dados
$host = 'localhost'; // Endereço do servidor MySQL
$user = 'root'; // Usuário do banco de dados
$password = 'root'; // Senha do banco de dados
$database = 'padaria_pão_genial'; // Nome do banco de dados

// Criando a conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verificando se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Exibindo mensagem de sucesso
echo "Conexão bem-sucedida com o banco de dados!";

// Fechando a conexão (opcional, caso não seja mais necessária)
// $conn->close();
?>