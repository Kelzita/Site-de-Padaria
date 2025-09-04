<?php
require_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nome = trim($_POST['nome_produto']);
    $descricao = trim($_POST['descricao']);
    $preco = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco']);
    $preco = floatval($preco);
    $unmedida = $_POST['unmedida'];
    $validade = $_POST['validade'] ?? null;
    $id_fornecedor = $_POST['id_fornecedor'];
    $quantidade = $_POST['quantidade_produto'];

    if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] === UPLOAD_ERR_OK) {
        $imagem_blob = file_get_contents($_FILES['imagem_produto']['tmp_name']);
    } else {
        $imagem_blob = null;
    }

    $stmt = $pdo->prepare("INSERT INTO produto 
        (nome_produto, descricao, preco, unmedida, validade, imagem_produto, id_fornecedor, quantidade_produto)
        VALUES (:nome, :descricao, :preco, :unmedida, :validade, :imagem, :fornecedor, :quantidade)");

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':unmedida', $unmedida);
    $stmt->bindParam(':validade', $validade);
    $stmt->bindParam(':imagem', $imagem_blob, PDO::PARAM_LOB);
    $stmt->bindParam(':fornecedor', $id_fornecedor);
    $stmt->bindParam(':quantidade', $quantidade);

    if ($stmt->execute()) {
        echo "<script>alert('Produto cadastrado com sucesso!'); window.location.href='../html_listas/lista_de_produto.php';</script>";
        exit;
    } else {
        echo "Erro ao cadastrar produto!";
    }
}
