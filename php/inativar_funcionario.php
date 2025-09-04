<?php
require_once 'conexao.php';

// Resposta padrão
header('Content-Type: application/json');
$response = ['sucesso' => false, 'ativo' => null];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_funcionario'])) {
    $id = intval($_POST['id_funcionario']);

    try {
        // Pega status atual
        $stmt = $pdo->prepare("SELECT ativo FROM funcionarios WHERE id_funcionario = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($funcionario) {
            // Inverte status
            $novoStatus = $funcionario['ativo'] ? 0 : 1;

            // Atualiza no banco
            $update = $pdo->prepare("UPDATE funcionarios SET ativo = :ativo WHERE id_funcionario = :id");
            $update->bindParam(':ativo', $novoStatus, PDO::PARAM_INT);
            $update->bindParam(':id', $id, PDO::PARAM_INT);
            $update->execute();

            $response['sucesso'] = true;
            $response['ativo'] = $novoStatus;
        }
    } catch (PDOException $e) {
        $response['erro'] = $e->getMessage();
    }
}

echo json_encode($response);
