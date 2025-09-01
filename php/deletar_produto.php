<?php
header('Content-Type: application/json');
require '../php/conexao.php'; // Ajuste o caminho conforme sua estrutura de pastas

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe JSON do corpo da requisição
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id'])) {
        $id = intval($input['id']);

        $sql = "DELETE FROM produtos WHERE id_produto = ?";
        $stmt = $conexao->prepare($sql);

        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Erro na preparação da query']);
            exit;
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Produto deletado com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao deletar produto']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'ID não enviado']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}
?>
