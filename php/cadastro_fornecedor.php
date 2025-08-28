<?php 
require_once 'conexao.php'; 

#if($_SESSION["id_funcao"] != 1) { 
    #echo "<script>alert('Acesso negado!'); window.location.href='../principal.php=?id';</script>";
#}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $razao_social = $_POST['razao_social'];
    $responsavel = $_POST['responsavel'];
    $cnpj_fornecedor = $_POST['cnpj_fornecedor'];
    $telefone_fornecedor = $_POST['telefone_fornecedor'];
    $email_fornecedor = $_POST['email_fornecedor'];
    $cep_fornecedor = $_POST['cep_fornecedor'];
    $rua_fornecedor = $_POST['rua_fornecedor'];
    $numero_fornecedor = $_POST['numero_fornecedor'];
    $bairro_fornecedor = $_POST['bairro_fornecedor'];
    $cidade_fornecedor = $_POST['cidade_fornecedor'];
    $uf_fornecedor = $_POST['uf_fornecedor'];

    $sql = "INSERT INTO fornecedores ( razao_social, responsavel, cnpj_fornecedor, telefone_fornecedor, email_fornecedor, cep_fornecedor, rua_fornecedor,numero_fornecedor, bairro_fornecedor, cidade_fornecedor, uf_fornecedor ) VALUES ( :razao_social, :responsavel, :cnpj_fornecedor, :telefone_fornecedor, :email_fornecedor, :cep_fornecedor, :rua_fornecedor,:numero_fornecedor, :bairro_fornecedor, :cidade_fornecedor, :uf_fornecedor )";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':razao_social', $razao_social);
    $stmt->bindParam(':responsavel', $responsavel);
    $stmt->bindParam(':cnpj_fornecedor', $cnpj_fornecedor);
    $stmt->bindParam(':telefone_fornecedor', $telefone_fornecedor);
    $stmt->bindParam(':email_fornecedor', $email_fornecedor);
    $stmt->bindParam(':cep_fornecedor', $cep_fornecedor);
    $stmt->bindParam(':rua_fornecedor', $rua_fornecedor);
    $stmt->bindParam(':numero_fornecedor', $numero_fornecedor);
    $stmt->bindParam(':bairro_fornecedor', $bairro_fornecedor);
    $stmt->bindParam(':cidade_fornecedor', $cidade_fornecedor);
    $stmt->bindParam(':uf_fornecedor', $uf_fornecedor); 

    try{
      $stmt->execute();
         echo "<script>alert('Fornecedor cadastrado com sucesso!'); window.location.href='../html_cadastros/cadastrar_fornecedor.php';</script>";
    } catch(PDOException $e) {
        echo "<script>alert('Erro ao cadastrar Fornecedor: ".$e->getMessage()."');</script>";
    }


}

?>