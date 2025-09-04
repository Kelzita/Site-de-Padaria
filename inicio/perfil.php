<?php
session_start();
require_once '../php/conexao.php';

// Verifica se o funcionário está logado
if (!isset($_SESSION['id_funcionario'])) {
    header("Location: login.php");
    exit;
}

$id_funcionario = $_SESSION['id_funcionario'];

// Buscar dados do funcionário
try {
    $stmt = $pdo->prepare("SELECT nome_funcionario, imagem_funcionario FROM funcionarios WHERE id_funcionario = :id");
    $stmt->bindParam(':id', $id_funcionario, PDO::PARAM_INT);
    $stmt->execute();
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao carregar dados: " . $e->getMessage();
    exit;
}

// Placeholder caso não haja imagem
$imagem = !empty($funcionario['imagem_funcionario'])
    ? 'data:image/jpeg;base64,' . base64_encode($funcionario['imagem_funcionario'])
    : '../img/sem_foto.png';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Funcionário</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/style_cadastro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<header>
    <img src="../img/logo.png" alt="Logo">
</header>

<div class="container">
    <h1>Meu Perfil</h1>
    <h2><?= htmlspecialchars($funcionario['nome_funcionario']); ?></h2>

    <form action="../php/alterar_imagem_funcionario.php" method="POST" enctype="multipart/form-data" class="formulario-cadastro">
        <div class="perfil-imagem">
            <img src="<?= $imagem ?>" alt="Foto do Funcionário" id="imagem_preview" style="width:150px; height:150px; object-fit:cover; border-radius:50%; border:2px solid #fff;">
        </div>

        <label for="imagem_funcionario"><i class="fa-solid fa-image"></i> Alterar Imagem:</label>
        <input type="file" name="imagem_funcionario" id="imagem_funcionario" accept="image/*">

        <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Salvar Alterações</button>
    </form>
</div>

<script>
const inputFile = document.getElementById('imagem_funcionario');
const preview = document.getElementById('imagem_preview');

inputFile.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if(file) {
        const reader = new FileReader();
        reader.onload = e => preview.src = e.target.result;
        reader.readAsDataURL(file);
    }
});
</script>
</body>
</html>
