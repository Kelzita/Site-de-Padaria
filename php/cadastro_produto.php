<?php
session_start();
require_once "conexao.php";

// Habilitar exibição de erros PDO para facilitar debug
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Buscar fornecedores para popular o select
$stmt_fornecedores = $pdo->query("SELECT id_fornecedor FROM fornecedores ORDER BY id_fornecedor");
$fornecedores = $stmt_fornecedores->fetchAll(PDO::FETCH_ASSOC);

//if($_SESSION['id_funcao'] != 1) {
//    echo ("<script>alert('Acesso Negado! Retornando para a página inicial...'); window.location.href='../HTML/principal.php';");
//}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // Pegando e sanitizando (pode melhorar com filtro depois)
    $nome_produto = trim($_POST['nome_produto'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = $_POST['preco'] ?? null;
    $unmedida = trim($_POST['unmedida'] ?? '');
    $validade = $_POST['validade'] ?? null;
    $id_fornecedor = $_POST['id_fornecedor'] ?? null;
    $quantidade_produto = $_POST['quantidade_produto'] ?? null; // NOVO CAMPO

    // Validação básica (pode melhorar)
    if (!$nome_produto || !$id_fornecedor || !$preco || !$quantidade_produto) { // incluí quantidade_produto aqui
        echo "<script>alert('Por favor, preencha os campos obrigatórios (nome, fornecedor, preço, quantidade).');</script>";
        exit;
    }

    // Validar fornecedor
    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM fornecedores WHERE id_fornecedor = :id_fornecedor");
    $stmt_check->bindParam(':id_fornecedor', $id_fornecedor);
    $stmt_check->execute();
    if ($stmt_check->fetchColumn() == 0) {
        echo "<script>alert('Fornecedor inválido!');</script>";
        exit;
    }

    // Tratar upload da imagem - parte corrigida
    $imagem_nome = null;
    if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] === 0) {
        // Defina o diretório de destino com caminho absoluto
        $upload_dir = __DIR__ . '/../uploads/';

        // Verificar se a pasta existe, se não, criar
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $extensao = pathinfo($_FILES['imagem_produto']['name'], PATHINFO_EXTENSION);
        $imagem_nome = uniqid() . '.' . $extensao;
        $destino = $upload_dir . $imagem_nome;

        if (!move_uploaded_file($_FILES['imagem_produto']['tmp_name'], $destino)) {
            echo "<script>alert('Erro ao mover o arquivo da imagem. Verifique permissões da pasta uploads.');</script>";
            exit;
        }
    } else {
        echo "<script>alert('Erro no upload da imagem ou imagem não enviada.');</script>";
        exit;
    }

    try {
        // ALTEREI aqui para incluir quantidade_produto no INSERT
        $sql = "INSERT INTO produto(nome_produto, descricao, preco, unmedida, validade, imagem_produto, id_fornecedor, quantidade_produto) 
                VALUES (:nome_produto, :descricao, :preco, :unmedida, :validade, :imagem_produto, :id_fornecedor, :quantidade_produto)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nome_produto", $nome_produto);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":unmedida", $unmedida);
        $stmt->bindParam(":validade", $validade);
        $stmt->bindParam(":imagem_produto", $imagem_nome);
        $stmt->bindParam(":id_fornecedor", $id_fornecedor);
        $stmt->bindParam(":quantidade_produto", $quantidade_produto); // Novo bindParam

        if ($stmt->execute()) {
            echo "<script>alert('Produto cadastrado com sucesso!'); window.location.href = '../php/cadastro_produto.php';</script>";
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "<script>alert('Erro ao cadastrar produto: {$errorInfo[2]}');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erro PDO: " . addslashes($e->getMessage()) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- jQuery primeiro -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JS do Select2 depois -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/style_cadastro.css" />
</head>
<body>
<header>
    <img src="../img/logo.png" alt="Logo" >
    <!--Menu-->
</header>
<div class="container">
    <h1>Cadastrar Produto</h1>
    <form class="formulario-cadastro" method="POST" action="../php/cadastro_produto.php" enctype="multipart/form-data" onsubmit="return validacaoProduto(event)">

        <label for="nome_produto"><i class="fas fa-barcode"></i> Nome do Produto:</label>
        <input type="text" id="nome_produto" name="nome_produto" placeholder="Insira o nome do produto" required>

        <label for="descricao"><i class="fas fa-barcode"></i> Descrição:</label>
        <input type="text" id="descricao" name="descricao" placeholder="Digite uma descrição">

        <label for="preco"><i class="fas fa-dollar-sign"></i> Preço:</label>
        <input type="number" step="0.01" id="preco" name="preco" placeholder="R$ 0,00" required>

        <label for="unmedida"><i class="fas fa-cube"></i> Unidade de Medida:</label>
        <input type="text" id="unmedida" name="unmedida" placeholder="Ex: Kg, un, L">

        <label for="validade"><i class="fas fa-calendar-alt"></i> Validade:</label>
        <input type="date" id="validade" name="validade">

        <label for="id_fornecedor"><i class="fas fa-truck"></i> Fornecedor:</label>
        <select name="id_fornecedor" id="id_fornecedor" required>
            <option value="">Selecione o fornecedor</option>
            <?php foreach ($fornecedores as $fornecedor): ?>
                <option value="<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>">
                    <?= htmlspecialchars($fornecedor['id_fornecedor']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Campo quantidade_produto adicionado -->
        <label for="quantidade_produto"><i class="fas fa-boxes"></i> Quantidade:</label>
        <input type="number" id="quantidade_produto" name="quantidade_produto" min="1" placeholder="Quantidade do produto" required>

        <label for="imagem_produto"><i class="fa-solid fa-image"></i> Foto do Produto:</label>
        <input type="file" name="imagem_produto" id="imagem_produto" required>

        <input type="hidden" name="id_estoque" id="id_estoque">

        <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Cadastrar</button>
    </form>
</div>
<script src="../js/validacao_cad_produto.js"></script>
</body>
</html>
