<?php
require_once "conexao.php";

session_start();

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $nome = trim($_POST['nome_funcionario']);
    $cpf = trim($_POST['cpf_funcionario']);
    $email = trim($_POST['email_funcionario']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $telefone = trim($_POST['telefone_funcionario']);
    $cep = trim($_POST['cep_funcionario']);
    $rua = trim($_POST['rua_funcionario']);
    $numero = trim($_POST['numero_funcionario']);
    $bairro = trim($_POST['bairro_funcionario']);
    $cidade = trim($_POST['cidade_funcionario']);
    $uf = trim($_POST['uf_funcionario']);
    $data_admissao = $_POST['data_admissao'];
    $salario = str_replace(['R$', '.'], '', $_POST['salario']);
    $salario = str_replace(',', '.', $salario);
    $salario = floatval($salario);
    $id_funcao = $_POST['id_funcao'];

    $stmt = $pdo->prepare("INSERT INTO funcionarios
        (nome_funcionario, cpf_funcionario, email_funcionario, senha, telefone_funcionario, cep_funcionario, rua_funcionario, numero_funcionario, bairro_funcionario, cidade_funcionario, uf_funcionario, data_admissao, salario, id_funcao)
        VALUES
        (:nome, :cpf, :email, :senha, :telefone, :cep, :rua, :numero, :bairro, :cidade, :uf, :data_admissao, :salario, :id_funcao)");

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':rua', $rua);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':uf', $uf);
    $stmt->bindParam(':data_admissao', $data_admissao);
    $stmt->bindParam(':salario', $salario);
    $stmt->bindParam(':id_funcao', $id_funcao);

    if($stmt->execute()){
        echo "<script>alert('Funcionário cadastrado com sucesso!'); window.location.href='../html_cadastros/cadastrar_funcionario.php';</script>";
        exit;
    } else {
        echo "Erro ao cadastrar funcionário!";
    }
}
?>
