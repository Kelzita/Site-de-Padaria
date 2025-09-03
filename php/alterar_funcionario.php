<?php 
session_start();
require_once 'conexao.php';

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
    $foto_atual = $_POST['foto_atual'];

    // Atualiza os dados do funcionário
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
            uf_funcionario = :uf_funcionario 
            WHERE id_funcionario = :id_funcionario";

    $stmt = $pdo->prepare($sql);
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

    if($stmt->execute()) {
        echo "<script>
            alert('Funcionário atualizado com sucesso!');
            window.location.href='../html_listas/lista_de_funcionarios.php';
        </script>"; 
    } else {
        // Caso dê erro, abre o modal preenchendo os campos
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById('modalEditarFuncionario');
                if (modal) {
                    modal.style.display = 'flex';

                    document.getElementById('alterar-id_funcionario').value = ".json_encode($id_funcionario).";
                    document.getElementById('alterar-nome_funcionario').value = ".json_encode($nome_funcionario).";
                    document.getElementById('alterar-cpf_funcionario').value = ".json_encode($cpf_funcionario).";
                    document.getElementById('alterar-email_funcionario').value = ".json_encode($email_funcionario).";
                    document.getElementById('alterar-telefone_funcionario').value = ".json_encode($telefone_funcionario).";
                    document.getElementById('alterar-data_admissao').value = ".json_encode($data_admissao).";
                    document.getElementById('alterar-salario').value = ".json_encode($salario).";
                    document.getElementById('alterar-id_funcao').value = ".json_encode($id_funcao).";
                    document.getElementById('alterar-cep_funcionario').value = ".json_encode($cep_funcionario).";
                    document.getElementById('alterar-rua_funcionario').value = ".json_encode($rua_funcionario).";
                    document.getElementById('alterar-numero_funcionario').value = ".json_encode($numero_funcionario).";
                    document.getElementById('alterar-bairro_funcionario').value = ".json_encode($bairro_funcionario).";
                    document.getElementById('alterar-cidade_funcionario').value = ".json_encode($cidade_funcionario).";
                    document.getElementById('alterar-uf_funcionario').value = ".json_encode($uf_funcionario).";
                    document.getElementById('foto_atual').value = ".json_encode($foto_atual).";

                    alert('Erro ao atualizar o funcionário!');
                }
            });
        </script>";
    }
}
?>
