<?php
session_start();
require_once "conexao.php";


if($_SESSION['id_funcao'] != 1) {
    echo ("<script>alert('Acesso Negado! Retornando para a página inicial...'); window.location.href='../HTML/principal.php';");
}

// Habilitar exibição de erros PDO para facilitar debug
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Buscar fornecedores para popular o select
$stmt_fornecedores = $pdo->query("SELECT id_fornecedor FROM fornecedores ORDER BY id_fornecedor");
$fornecedores = $stmt_fornecedores->fetchAll(PDO::FETCH_ASSOC);


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
            echo "<script>alert('Produto cadastrado com sucesso!'); window.location.href = '../html_cadastros/cadastrar_produto.php';</script>";
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "<script>alert('Erro ao cadastrar produto: {$errorInfo[2]}');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erro PDO: " . addslashes($e->getMessage()) . "');</script>";
    }
}
?>
