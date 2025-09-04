<?php
session_start();
require 'conexao.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produto = $_POST['id_produto'];
    $nome_produto = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $preco = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco']);
   $preco = floatval($preco);

    $quantidade_produto = $_POST['quantidade_produto'];
    $validade = $_POST['validade'];
    $unmedida = $_POST['unmedida'];

    $imagem_blob = null;
    if(isset($_FILES['foto_produto']) && $_FILES['foto_produto']['error'] === UPLOAD_ERR_OK) {
        $imagem_blob = file_get_contents($_FILES['foto_produto']['tmp_name']);
    }

    if($imagem_blob) {
        $sql = "UPDATE produto SET 
                    nome_produto=:nome_produto,
                    descricao=:descricao,
                    quantidade_produto=:quantidade_produto,
                    preco=:preco,
                    validade=:validade,
                    unmedida=:unmedida,
                    imagem_produto=:imagem_produto
                WHERE id_produto=:id_produto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':imagem_produto', $imagem_blob, PDO::PARAM_LOB);
    } else {
        $sql = "UPDATE produto SET 
                    nome_produto=:nome_produto,
                    descricao=:descricao,
                    quantidade_produto=:quantidade_produto,
                    preco=:preco,
                    validade=:validade,
                    unmedida=:unmedida
                WHERE id_produto=:id_produto";
        $stmt = $pdo->prepare($sql);
    }

    $stmt->bindParam(':nome_produto',$nome_produto);
    $stmt->bindParam(':descricao',$descricao);
    $stmt->bindParam(':quantidade_produto',$quantidade_produto);
    $stmt->bindParam(':preco',$preco);
    $stmt->bindParam(':validade',$validade);
    $stmt->bindParam(':unmedida',$unmedida);
    $stmt->bindParam(':id_produto',$id_produto);
    $stmt->execute();

    echo "<script>alert('Produto atualizado com sucesso!');window.location.href='../html_listas/lista_de_produto.php';</script>";
    exit;
}
?>
