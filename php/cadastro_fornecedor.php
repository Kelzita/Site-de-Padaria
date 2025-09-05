<?php
require_once "conexao.php";

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $razao_social = trim($_POST['razao_social']);
    $responsavel = trim($_POST['responsavel']);
    $cnpj = trim($_POST['cnpj_fornecedor']);
    $telefone = trim($_POST['telefone_fornecedor']);
    $email = trim($_POST['email_fornecedor']);
    $cep = trim($_POST['cep_fornecedor']);
    $rua = trim($_POST['rua_fornecedor']);
    $numero = trim($_POST['numero_fornecedor']);
    $bairro = trim($_POST['bairro_fornecedor']);
    $cidade = trim($_POST['cidade_fornecedor']);
    $uf = trim($_POST['uf_fornecedor']);


    $stmt = $pdo->prepare("INSERT INTO fornecedores
        (razao_social, responsavel, cnpj_fornecedor, telefone_fornecedor, email_fornecedor, cep_fornecedor, rua_fornecedor, numero_fornecedor, bairro_fornecedor, cidade_fornecedor, uf_fornecedor)
        VALUES
        (:razao_social, :responsavel, :cnpj, :telefone, :email, :cep, :rua, :numero, :bairro, :cidade, :uf)");

    $stmt->bindParam(':razao_social', $razao_social);
    $stmt->bindParam(':responsavel', $responsavel);
    $stmt->bindParam(':cnpj', $cnpj);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':rua', $rua);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':uf', $uf);

    if($stmt->execute()){
        echo "<script>alert('Fornecedor cadastrado com sucesso!'); window.location.href='../html_cadastros/cadastrar_fornecedor.php';</script>";
        exit;
    } else {
        echo "Erro ao cadastrar fornecedor!";
    }
}
?>
