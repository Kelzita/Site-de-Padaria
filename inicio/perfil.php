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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
    /* ====== ESTILOS GERAIS - PERFIL FUNCIONÁRIO ====== */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #f5f7fa;
    color: #333;
    line-height: 1.6;
}


/* ====== CONTAINER PRINCIPAL ====== */
.container {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    text-align: center;
}

.container h1 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.container h2 {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    color: #555;
}

/* ====== FORMULÁRIO ====== */
.formulario {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.container-foto {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.previsualizacao-foto {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #1a1a1a;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
}

.previsualizacao-foto:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 25px rgba(0,0,0,0.2);
}

.entrada-foto {
    display: none;
}

.rotulo-foto {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    background: #1a1a1a;
    color: #fff;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
    margin-top: 1rem;
}

.rotulo-foto:hover {
    background: #333;
    transform: translateY(-2px);
}

.instrucoes-foto {
    font-size: 0.85rem;
    color: #777;
    margin-top: 0.5rem;
}

/* ====== BOTÕES ====== */
.acoes-formulario {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
}

.botao {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.botao--primario {
    background: #1a1a1a;
    color: white;
}

.botao--primario:hover {
    background: #333;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* ====== RESPONSIVIDADE ====== */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 1.5rem;
    }

    .previsualizacao-foto {
        width: 120px;
        height: 120px;
    }
}

@media (max-width: 480px) {
    .previsualizacao-foto {
        width: 100px;
        height: 100px;
    }

    .rotulo-foto {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
}

</style>
<body>
<header>
    <img src="../img/logo.png" alt="Logo">
</header>

<div class="container">
    <h1>Meu Perfil</h1>
    <h2><?= htmlspecialchars($funcionario['nome_funcionario']); ?></h2>

    <form action="../php/alterar_imagem_funcionario.php" method="POST" enctype="multipart/form-data" class="formulario">
        <div class="container-foto">
            <img src="<?= $imagem ?>" alt="Foto do Funcionário" id="imagem_preview" class="previsualizacao-foto">
            <label for="imagem_funcionario" class="rotulo-foto"><i class="fa-solid fa-image"></i> Alterar Imagem</label>
            <input type="file" name="imagem_funcionario" id="imagem_funcionario" class="entrada-foto" accept="image/*">
            <span class="instrucoes-foto">Clique na imagem ou no botão acima para alterar</span>
        </div>

        <div class="acoes-formulario">
            <button type="submit" class="botao botao--primario"><i class="fas fa-save"></i> Salvar Alterações</button>
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

// Também permite clicar na imagem para abrir o input
preview.addEventListener('click', () => inputFile.click());
</script>
</body>
</html>
