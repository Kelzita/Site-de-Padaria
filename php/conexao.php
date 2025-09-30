<?php
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$db   = getenv('DB_NAME');

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<script>alert('Conectado com sucesso ao banco!');</script>";
} catch (PDOException $e) {
    die("<script>alert('Erro ao conectar-se ao banco');</script>" . $e->getMessage());
}
?>
