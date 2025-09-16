<?php
require_once 'conexao.php';

header('Content-Type: application/json');
$response = ['sucesso' => false, 'ativo' => null];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_fornecedor'])) {
    $id = intval($_POST['id_fornecedor']);

    try {
        // Pega status atual
        $stmt = $pdo->prepare("SELECT ativo FROM fornecedores WHERE id_fornecedor = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fornecedor) {
            // Inverte status
            $novoStatus = $fornecedor['ativo'] ? 0 : 1;

            // Atualiza no banco
            $update = $pdo->prepare("UPDATE fornecedores SET ativo = :ativo WHERE id_fornecedor = :id");
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
?>