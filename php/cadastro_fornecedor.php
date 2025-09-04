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

    // Lida com o arquivo de imagem
    $foto = null;
    if(isset($_FILES['foto_fornecedor']) && $_FILES['foto_fornecedor']['error'] === UPLOAD_ERR_OK){
        $foto = file_get_contents($_FILES['foto_fornecedor']['tmp_name']);
    }

    $stmt = $pdo->prepare("INSERT INTO fornecedores
        (razao_social, responsavel, cnpj_fornecedor, telefone_fornecedor, email_fornecedor, cep_fornecedor, rua_fornecedor, numero_fornecedor, bairro_fornecedor, cidade_fornecedor, uf_fornecedor, foto_fornecedor)
        VALUES
        (:razao_social, :responsavel, :cnpj, :telefone, :email, :cep, :rua, :numero, :bairro, :cidade, :uf, :foto)");

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
    $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);

    if($stmt->execute()){
        echo "<script>alert('Fornecedor cadastrado com sucesso!'); window.location.href='../html_listas/lista_de_fornecedores.php';</script>";
        exit;
    } else {
        echo "Erro ao cadastrar fornecedor!";
    }
}
?>
