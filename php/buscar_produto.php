<?php
session_start();
require_once("conexao.php");

$produtos = [];

try {
    // Consulta base com JOIN
    $sql = "SELECT p.*, f.razao_social AS fornecedor_nome
            FROM produto p
            LEFT JOIN fornecedores f ON p.id_fornecedor = f.id_fornecedor
            ORDER BY p.nome_produto ASC";

    if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty(trim($_POST['busca']))) {
        $busca = trim($_POST['busca']);

        if (is_numeric($busca)) {
            // Busca por ID exato
            $sql = "SELECT p.*, f.razao_social AS fornecedor_nome
                    FROM produto p
                    LEFT JOIN fornecedores f ON p.id_fornecedor = f.id_fornecedor
                    WHERE p.id_produto = :busca
                    ORDER BY p.nome_produto ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            // Busca por nome começando com o termo
            $sql = "SELECT p.*, f.razao_social AS fornecedor_nome
                    FROM produto p
                    LEFT JOIN fornecedores f ON p.id_fornecedor = f.id_fornecedor
                    WHERE p.nome_produto LIKE :busca_nome
                    ORDER BY p.nome_produto ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
        }
    } else {
        // Sem busca, lista todos
        $stmt = $pdo->prepare($sql);
    }

    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ajustes para modal/JS
    foreach ($produtos as &$produto) {
        $produto['unidade_medida'] = $produto['unmedida'];
        $produto['foto_produto'] = $produto['imagem_produto'];
    }

} catch (PDOException $e) {
    echo "Erro ao buscar produtos: " . $e->getMessage();
}
?>