<?php
session_start();
require_once '../php/conexao.php';

if (!isset($_SESSION['id_funcionario'])) {
    header("Location: login.php");
    exit;
}

$id_funcionario = $_SESSION['id_funcionario'];

try {
    $stmt = $pdo->prepare("SELECT nome_funcionario, imagem_funcionario, senha FROM funcionarios WHERE id_funcionario = :id");
    $stmt->bindParam(':id', $id_funcionario, PDO::PARAM_INT);
    $stmt->execute();
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$funcionario) {
        echo "<script>alert('Funcionário não encontrado!'); window.location.href='login.php';</script>";
        exit;
    }
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
<link rel="stylesheet" href="../css/styleperfilfunc.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="icon" href="img/logo_title.png">
</head>

<body>

<div class="container">
<a href="../inicio/home.php" class="voltar"> 
        <img class="seta" src="../img/btn_voltar.png" title="seta">
</a>
    <h1>Meu Perfil</h1>
    <h2><?= htmlspecialchars($funcionario['nome_funcionario']); ?></h2>
    
    <form action="../php/alterar_perfil_funcionario.php" method="POST" enctype="multipart/form-data" class="formulario">
        <div class="container-foto">
            <img src="<?= $imagem ?>" alt="Foto do Funcionário" id="imagem_preview" class="previsualizacao-foto">
            <label for="imagem_funcionario" class="rotulo-foto"><i class="fa-solid fa-image"></i> Alterar Imagem</label>
            <input type="file" name="imagem_funcionario" id="imagem_funcionario" class="entrada-foto" accept="image/*">
            <span class="instrucoes-foto">Clique na imagem ou no botão acima para alterar</span>
        </div>

        <!-- Nova senha opcional -->
        <label for="nova_senha">Nova Senha (opcional):</label>
        <input type="password" id="nova_senha" name="nova_senha" placeholder="Digite a nova senha">

        <label for="conf_senha">Confirmar Nova Senha:</label>
        <input type="password" id="conf_senha" name="conf_senha" placeholder="Confirme a nova senha">

        <div class="acoes-formulario">
            <button type="submit" class="botao botao--primario"><i class="fas fa-save"></i>   Salvar Alterações</button>
        </div>
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

preview.addEventListener('click', () => inputFile.click());
</script>
</body>
</html>
