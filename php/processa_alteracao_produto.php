<?php
session_start();
require 'conexao.php';

//if($_SESSION['perfil'] !=1){
    //echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    //exit();
//}

if($_SERVER["REQUEST_METHOD"] =="POST"){
    $id_produto = $_POST['id_produto'];
    $nome_produto = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade_produto= $_POST['quantidade_produto'];
    $validade = $_POST['validade'];
    $unmedida = $_POST['unmedida'];

    //atualiza os dados do usuario
    
    
        $sql = "UPDATE produto SET nome_produto = :nome_produto,descricao = :descricao,quantidade_produto=:quantidade_produto , preco = :preco , validade = :validade , unmedida = :unmedida WHERE id_produto = :id_produto";
        $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':nome_produto',$nome_produto);
    $stmt->bindParam(':descricao',$descricao);
    $stmt->bindParam(':quantidade_produto',$quantidade_produto);
    $stmt->bindParam(':preco',$preco);
    $stmt->bindParam(':validade',$validade);
    $stmt->bindParam(':id_produto',$id_produto);
    $stmt->bindParam(':unmedida',$unmedida);
    
    if($stmt->execute()){
        echo "<script>alert('Produto atualizado co sucesso!');window.location.href='html_listas/lista_de_produto.php';</script>";

    }else{
        echo "<script>alert('Erro ao atualizar produto');window.location.href=alterar_produto.php?id=$id_produto';</script>";
    }
}
?>