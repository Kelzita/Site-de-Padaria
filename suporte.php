<?php 
session_start();
require_once 'conexao.php';

//Verifica se o perfil logado é adm, secretária ou almoxarife
if($_SESSION['perfil'] !=1 && $_SESSION['perfil'] != 2 && $_SESSION['perfil'] != 3) {
    echo "<script>alert('Acesso negado!'); window.location.href='principal.php';</script>";
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_fornecedor = $_POST['id_fornecedor'];
    $nome_fornecedor = $_POST['nome_fornecedor'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $contato = $_POST['contato'];
}

//Atualiza os dados do Fornecedor
$sql = "UPDATE fornecedor SET nome_fornecedor = :nome_fornecedor, endereco = :endereco, telefone = :telefone, email = :email, contato = :contato WHERE id_fornecedor = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nome_fornecedor', $nome_fornecedor);
$stmt->bindParam(':endereco', $endereco);
$stmt->bindParam(':telefone', $telefone);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':contato', $contato);
$stmt->bindParam(':id', $id_fornecedor);

if($stmt->execute()) {
    echo "<script>alert('Fornecedor atualizado com sucesso!'); window.location.href='buscar_fornecedor.php';</script>"; 
} else {
    echo "<script>alert('Erro ao atualizar o Fornecedor!');window.location.href='alterar_fornecedor.php?=$id_fornecedor';</script>";
}
?>
