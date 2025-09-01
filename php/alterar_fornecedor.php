<?php 
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $razao_social = $_POST['razao_social'];
    $responsavel = $_POST['responsavel'];
    $cnpj_fornecedor = $_POST['cnpj_fornecedor'];
    $email_fornecedor = $_POST['email_fornecedor'];
    $telefone_fornecedor = $_POST['telefone_fornecedor'];
    $cep_fornecedor = $_POST['cep_fornecedor'];
    $rua_fornecedor = $_POST['rua_fornecedor'];
    $numero_fornecedor = $_POST['numero_fornecedor'];
    $bairro_fornecedor = $_POST['bairro_fornecedor'];
    $cidade_fornecedor = $_POST['cidade_fornecedor'];
    $uf_fornecedor = $_POST['uf_fornecedor'];

    // Atualiza os dados do Fornecedor
    $sql = "UPDATE fornecedores SET razao_social = :razao_social, responsavel = :responsavel, cnpj_fornecedor = :cnpj_fornecedor,  email_fornecedor = :email_fornecedor, telefone_fornecedor = :telefone_fornecedor, cep_fornecedor = :cep_fornecedor, rua_fornecedor = :rua_fornecedor, numero_fornecedor = :numero_fornecedor, bairro_fornecedor = :bairro_fornecedor, cidade_fornecedor = :cidade_fornecedor,  uf_fornecedor = :uf_fornecedor  "

}


?>
