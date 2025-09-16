<?php
require_once 'conexao.php';

header('Content-Type: application/json');
$response = ['sucesso' => false, 'ativo' => null];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produto'])) {
    $id = intval($_POST['id_produto']);

    try {
        // Verifica se o produto existe
        $stmt = $pdo->prepare("SELECT ativo FROM produto WHERE id_produto = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            // Inverte status
            $novoStatus = $produto['ativo'] ? 0 : 1;

            // Atualiza status no banco
            $update = $pdo->prepare("UPDATE produto SET ativo = :ativo WHERE id_produto = :id");
            $update->bindParam(':ativo', $novoStatus, PDO::PARAM_INT);
            $update->bindParam(':id', $id, PDO::PARAM_INT);
            $update->execute();

            $response['sucesso'] = true;
            $response['ativo'] = $novoStatus;
        } else {
            $response['erro'] = 'Produto não encontrado.';
        }

    } catch (PDOException $e) {
        $response['erro'] = $e->getMessage();
    }
} else {
    $response['erro'] = 'ID do produto não fornecido.';
}

echo json_encode($response);
