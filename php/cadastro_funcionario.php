<?php 
require_once 'conexao.php';

/*if($_SESSION['id_funcao'] != 1) {
    echo "<script>alert('Acesso negado!'); window.location.href='../principal.php=?id';</script>";
}*/

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_funcionario  = $_POST['nome_funcionario'];
    $cpf_funcionario  = $_POST['cpf_funcionario'];
    $email_funcionario  = $_POST['email_funcionario'];
    $senha = $_POST['senha'];
    $telefone_funcionario  = $_POST['telefone_funcionario'];
    $cep_funcionario  = $_POST['cep_funcionario'];
    $rua_funcionario  = $_POST['rua_funcionario'];
    $numero_funcionario  = $_POST['numero_funcionario'];
    $bairro_funcionario  = $_POST['bairro_funcionario'];
    $cidade_funcionario  = $_POST['cidade_funcionario'];
    $uf_funcionario  = $_POST['uf_funcionario'];
    $data_admissao  = $_POST['data_admissao'];
    $salario  = $_POST['salario'];
    $id_funcao  = $_POST['id_funcao'];

    // HASH da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO funcionarios (nome_funcionario, cpf_funcionario, email_funcionario, senha, telefone_funcionario, cep_funcionario, rua_funcionario, numero_funcionario, bairro_funcionario, cidade_funcionario, uf_funcionario, data_admissao, salario, id_funcao) 
            VALUES (:nome_funcionario, :cpf_funcionario, :email_funcionario, :senha, :telefone_funcionario, :cep_funcionario, :rua_funcionario, :numero_funcionario, :bairro_funcionario, :cidade_funcionario, :uf_funcionario, :data_admissao, :salario, :id_funcao)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_funcionario', $nome_funcionario);
    $stmt->bindParam(':cpf_funcionario', $cpf_funcionario);
    $stmt->bindParam(':email_funcionario', $email_funcionario);
    $stmt->bindParam(':senha', $senha_hash); 
    $stmt->bindParam(':telefone_funcionario', $telefone_funcionario);
    $stmt->bindParam(':cep_funcionario', $cep_funcionario);
    $stmt->bindParam(':rua_funcionario', $rua_funcionario);
    $stmt->bindParam(':numero_funcionario', $numero_funcionario);
    $stmt->bindParam(':bairro_funcionario', $bairro_funcionario);
    $stmt->bindParam(':cidade_funcionario', $cidade_funcionario);
    $stmt->bindParam(':uf_funcionario', $uf_funcionario);
    $stmt->bindParam(':data_admissao', $data_admissao);
    $stmt->bindParam(':salario', $salario);
    $stmt->bindParam(':id_funcao', $id_funcao);

    try { 
        $stmt->execute();
        echo "<script>alert('Funcionário cadastrado com sucesso!'); window.location.href='../html_cadastros/cadastrar_funcionario.php';</script>";
    } catch(PDOException $e) {
        echo "<script>alert('Erro ao cadastrar Funcionário:". $e->getMessage()."');</script>";
    }
}
?>