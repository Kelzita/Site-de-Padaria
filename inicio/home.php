<?php 
// Inicia a sessão antes de qualquer saída
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../php/menu.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_funcionario'])) {
    header("Location: ../index.php");
    exit();
}

// Conexão com o banco
require_once '../php/conexao.php';

// Busca o nome da função do funcionário logado
$id_funcao = $_SESSION['id_funcao'] ?? null;

$sql = "SELECT nome_funcao FROM funcao WHERE id_funcao = :id_funcao";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_funcao', $id_funcao, PDO::PARAM_INT);
$stmt->execute();
$funcao = $stmt->fetch(PDO::FETCH_ASSOC);

$nome_funcao = $funcao['nome_funcao'] ?? 'Função não encontrada';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="../css/stylehome.css">
</head>
<body>
<div class="retangulo">
    <h1>
        Bem-vindo(a) <?= htmlspecialchars($_SESSION['nome_funcionario']); ?> 
        <br>Função: <?= htmlspecialchars($nome_funcao); ?>
    </h1>

    <form action="../php/logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>
</div>
</body>
</html>
