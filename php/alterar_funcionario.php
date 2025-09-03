<?php 
session_start();
require_once '../php/conexao.php';
require_once '../php/funcoes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_funcionario = $_POST['id_funcionario'];
    $nome_funcionario = $_POST['nome_funcionario'];
    $cpf_funcionario = $_POST['cpf_funcionario'];
    $senha = $_POST['senha']; // se vazio, mantém a senha atual
    $email_funcionario = $_POST['email_funcionario'];
    $telefone_funcionario = $_POST['telefone_funcionario'];
    $data_admissao = $_POST['data_admissao'];
    $salario = $_POST['salario'];
    $id_funcao = $_POST['id_funcao'];
    $cep_funcionario = $_POST['cep_funcionario'];
    $rua_funcionario = $_POST['rua_funcionario'];
    $numero_funcionario = $_POST['numero_funcionario'];
    $bairro_funcionario = $_POST['bairro_funcionario'];
    $cidade_funcionario = $_POST['cidade_funcionario'];
    $uf_funcionario = $_POST['uf_funcionario'];
    
    // Tratamento da imagem
    $imagem_funcionario = null;
    if (!empty($_FILES['foto_funcionario']['name'])) {
        
        // Processar novo upload de imagem
        $imagem_temp = $_FILES['foto_funcionario']['tmp_name'];
        $imagem_funcionario = file_get_contents($imagem_temp);
    } elseif (!empty($_POST['foto_atual'])) {

        $imagem_funcionario = base64_decode($_POST['foto_atual']);
    }

    // Construir a query SQL
    $sql = "UPDATE funcionarios SET 
            nome_funcionario = :nome_funcionario, 
            cpf_funcionario = :cpf_funcionario, 
            email_funcionario = :email_funcionario, 
            telefone_funcionario = :telefone_funcionario, 
            data_admissao = :data_admissao, 
            salario = :salario, 
            id_funcao = :id_funcao, 
            cep_funcionario = :cep_funcionario, 
            rua_funcionario = :rua_funcionario, 
            numero_funcionario = :numero_funcionario, 
            bairro_funcionario = :bairro_funcionario, 
            cidade_funcionario = :cidade_funcionario, 
            uf_funcionario = :uf_funcionario";
    
    // Adicionar campo de senha se foi fornecida
    if (!empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql .= ", senha = :senha";
    }
    
    // Adicionar campo de imagem se foi fornecida
    if ($imagem_funcionario !== null) {
        $sql .= ", imagem_funcionario = :imagem_funcionario";
    }
    
    $sql .= " WHERE id_funcionario = :id_funcionario";

    $stmt = $pdo->prepare($sql);
    
    // Bind dos parâmetros
    $stmt->bindParam(':id_funcionario', $id_funcionario);
    $stmt->bindParam(':nome_funcionario', $nome_funcionario);
    $stmt->bindParam(':cpf_funcionario', $cpf_funcionario);
    $stmt->bindParam(':email_funcionario', $email_funcionario);
    $stmt->bindParam(':telefone_funcionario', $telefone_funcionario);
    $stmt->bindParam(':data_admissao', $data_admissao);
    $stmt->bindParam(':salario', $salario);
    $stmt->bindParam(':id_funcao', $id_funcao);
    $stmt->bindParam(':cep_funcionario', $cep_funcionario);
    $stmt->bindParam(':rua_funcionario', $rua_funcionario);
    $stmt->bindParam(':numero_funcionario', $numero_funcionario);
    $stmt->bindParam(':bairro_funcionario', $bairro_funcionario);
    $stmt->bindParam(':cidade_funcionario', $cidade_funcionario);
    $stmt->bindParam(':uf_funcionario', $uf_funcionario);
    
    if (!empty($senha)) {
        $stmt->bindParam(':senha', $senha_hash);
    }
    
    if ($imagem_funcionario !== null) {
        $stmt->bindParam(':imagem_funcionario', $imagem_funcionario, PDO::PARAM_LOB);
    }

    if($stmt->execute()) {
        echo "<script>
            alert('Funcionário atualizado com sucesso!');
            window.location.href='../html_listas/lista_de_funcionarios.php';
        </script>"; 
    } else {
        echo "<script>
            alert('Erro ao atualizar o funcionário!');
            window.history.back();
        </script>";
    }
}
?>