<?php 
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_fornecedor = $_POST['id_fornecedor'];
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
    $sql = "UPDATE fornecedores SET razao_social = :razao_social, responsavel = :responsavel, cnpj_fornecedor = :cnpj_fornecedor,  email_fornecedor = :email_fornecedor, telefone_fornecedor = :telefone_fornecedor, cep_fornecedor = :cep_fornecedor, rua_fornecedor = :rua_fornecedor, numero_fornecedor = :numero_fornecedor, bairro_fornecedor = :bairro_fornecedor, cidade_fornecedor = :cidade_fornecedor,  uf_fornecedor = :uf_fornecedor WHERE id_fornecedor = :id_fornecedor";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_fornecedor', $id_fornecedor);
    $stmt->bindParam(':razao_social', $razao_social);
    $stmt->bindParam(':responsavel', $responsavel);
    $stmt->bindParam(':cnpj_fornecedor', $cnpj_fornecedor);
    $stmt->bindParam(':email_fornecedor',$email_fornecedor);
    $stmt->bindParam(':telefone_fornecedor', $telefone_fornecedor);
    $stmt->bindParam(':cep_fornecedor', $cep_fornecedor);
    $stmt->bindParam(':rua_fornecedor', $rua_fornecedor);
    $stmt->bindParam(':numero_fornecedor', $numero_fornecedor);
    $stmt->bindParam(':bairro_fornecedor', $bairro_fornecedor);
    $stmt->bindParam(':cidade_fornecedor', $cidade_fornecedor);
    $stmt->bindParam(':uf_fornecedor', $uf_fornecedor);

    if($stmt->execute()) {
        echo "<script>
            alert('Fornecedor atualizado com sucesso!');
            window.location.href='../html_listas/lista_de_fornecedores.php';
        </script>"; 
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById('modalEditar');
                if (modal) {
                    modal.style.display = 'flex';
    
                    // Preenche os campos de forma segura
                    document.getElementById('alterar-id').value = ".json_encode($id_fornecedor).";
                    document.getElementById('alterar-razao_social').value = ".json_encode($razao_social).";
                    document.getElementById('alterar-responsavel').value = ".json_encode($responsavel).";
                    document.getElementById('alterar-cnpj_fornecedor').value = ".json_encode($cnpj_fornecedor).";
                    document.getElementById('alterar-email_fornecedor').value = ".json_encode($email_fornecedor).";
                    document.getElementById('alterar-telefone-fornecedor').value = ".json_encode($telefone_fornecedor).";
                    document.getElementById('alterar-cep_fornecedor').value = ".json_encode($cep_fornecedor).";
                    document.getElementById('alterar-rua_fornecedor').value = ".json_encode($rua_fornecedor).";
                    document.getElementById('alterar-numero_fornecedor').value = ".json_encode($numero_fornecedor).";
                    document.getElementById('alterar-bairro_fornecedor').value = ".json_encode($bairro_fornecedor).";
                    document.getElementById('alterar-cidade_fornecedor').value = ".json_encode($cidade_fornecedor).";
                    document.getElementById('alterar-uf_fornecedor').value = ".json_encode($uf_fornecedor).";
    
                    alert('Erro ao atualizar o fornecedor!');
                }
            });
        </script>";
    }
    
}
?>
