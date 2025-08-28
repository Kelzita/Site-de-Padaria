<?php
session_start();
require_once "conexao.php"; 



// Proteção de acesso
//if($_SESSION['id_funcao'] != 1) {
    //echo ("<script>alert('Acesso Negado! Retornando para a página inicial...'); window.location.href='../HTML/principal.php';</script>");
   // exit();
//}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $nome_produto = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $unmedida = $_POST['unmedida'];
    $quantidade = $_POST['quantidade_produto']; 
    $validade = $_POST['validade'];     
    $id_fornecedor = $_POST['id_fornecedor'];

    // Tratamento da imagem
    if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == 0) {
        $imagem_temp = $_FILES['imagem_produto']['tmp_name'];
        $imagem_binario = file_get_contents($imagem_temp);
    } else {
        $imagem_binario = null;
    }

    $sql = "INSERT INTO produto             
    (nome_produto, descricao, preco, quantidade_produto, unmedida, validade, id_fornecedor, imagem_produto) 
    VALUES (:nome_produto, :descricao, :preco, :quantidade_produto, :unmedida, :validade, :id_fornecedor, :imagem_produto)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome_produto", $nome_produto);
    $stmt->bindParam(":descricao", $descricao);
    $stmt->bindParam(":preco", $preco);
    $stmt->bindParam(":quantidade_produto", $quantidade); // corresponde ao $_POST
    $stmt->bindParam(":unmedida", $unmedida);
    $stmt->bindParam(":validade", $validade);
    $stmt->bindParam(":id_fornecedor", $id_fornecedor);
    $stmt->bindParam(":imagem_produto", $imagem_binario, PDO::PARAM_LOB);


    if($stmt->execute()){
        echo "<script>alert('Produto cadastrado com Sucesso!'); window.location.href='..php/cadastro_produto.php';</script>";
    } else {
        echo "<script>alert('Erro: não foi possível cadastrar o produto.');</script>";
    }
}
?>
