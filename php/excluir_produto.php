<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_produto'])) {
        $id = intval($_POST['id_produto']);

        require_once 'conexao.php'; // ou seu arquivo de conexão

        $stmt = $conn->prepare("DELETE FROM produtos WHERE id_produto = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'ID inválido']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método inválido']);
}
