<?php 
require_once '../php/conexao.php';

// Buscar fornecedores
try {
    $stmt_fornecedores = $pdo->query("SELECT id_fornecedor, razao_social FROM fornecedores ORDER BY id_fornecedor");
    $fornecedores = $stmt_fornecedores->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $fornecedores = [];
    echo "<script>console.error('Erro ao carregar fornecedores: " . $e->getMessage() . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/style_cadastro.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
<header>
    <img src="../img/logo.png" alt="Logo" />
</header>

<div class="container">
    <h1>Cadastrar Produto</h1>
    <form method="POST" action="../php/cadastro_produto.php" enctype="multipart/form-data" class="formulario-cadastro">

    <label for="nome_produto"><i class="fas fa-barcode"></i> Nome do Produto:</label>
            <input type="text" id="nome_produto" name="nome_produto" placeholder="Insira o nome do produto" required>

            <label for="descricao"><i class="ri-file-text-line"></i> Descrição:</label>
            <textarea id="descricao" name="descricao" placeholder="Insira uma descrição (Opcional)"></textarea>

            <label for="preco"><i class="fas fa-dollar-sign"></i> Preço:</label>
            <input type="text" id="preco" name="preco" placeholder="R$ 0,00" required>

            <label for="unmedida"><i class="fas fa-cube"></i> Unidade de Medida:</label>
            <select id="unmedida" name="unmedida" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="un">Unidade (un)</option>
                <option value="kg">Quilo (kg)</option>
                <option value="g">Grama (g)</option>
                <option value="l">Litro (L)</option>
            </select>

            <label for="quantidade_produto"><i class="fas fa-boxes"></i> Quantidade do Produto:</label>
            <input type="number" id="quantidade_produto" name="quantidade_produto" placeholder="Digite a quantidade disponível" min="1" required>

        <label for="validade"><i class="fas fa-calendar-alt"></i> Validade:</label>
        <input type="date" name="validade" id="validade">

        <label for="id_fornecedor"><i class="fas fa-truck"></i> Fornecedor:</label>
        <select name="id_fornecedor" id="id_fornecedor" required>
            <option value="">Selecione o fornecedor</option>
            <?php foreach ($fornecedores as $f): ?>
                <option value="<?= $f['id_fornecedor'] ?>"><?= $f['id_fornecedor'] ?> - <?= htmlspecialchars($f['razao_social']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="imagem_produto"><i class="fa-solid fa-image"></i> Foto:</label>
        <input type="file" name="imagem_produto" id="imagem_produto" required>

        <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Cadastrar</button>
    </form>
</div>
<script src="../javascript/produto.js"></script>
</body>
</html>
