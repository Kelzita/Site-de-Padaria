<?php
session_start();
require_once("conexao.php");

$produtos = [];

try {
    #============ LISTA ORDENADA POR ID ==============
    $sql = "SELECT p.*, f.razao_social AS fornecedor_nome
            FROM produto p
            LEFT JOIN fornecedores f ON p.id_fornecedor = f.id_fornecedor
            ORDER BY p.id_produto ASC";

    if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty(trim($_POST['busca']))) {
        $busca = trim($_POST['busca']);

        if (is_numeric($busca)) {
           #============ BUSCA POR ID =============
            $sql = "SELECT p.*, f.razao_social AS fornecedor_nome
                    FROM produto p
                    LEFT JOIN fornecedores f ON p.id_fornecedor = f.id_fornecedor
                    WHERE p.id_produto = :busca
                    ORDER BY p.nome_produto ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            #============ BUSCA POR NOME ===========
            $sql = "SELECT p.*, f.razao_social AS fornecedor_nome
                    FROM produto p
                    LEFT JOIN fornecedores f ON p.id_fornecedor = f.id_fornecedor
                    WHERE p.nome_produto LIKE :busca_nome
                    ORDER BY p.nome_produto ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
        }
    } else {
        #============ MOSTRA TODOS CASO NÃO TENHA BUSCA =========
        $stmt = $pdo->prepare($sql);
    }

    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    # Ajustes para o MODAL JS 
    foreach ($produtos as &$produto) {
        $produto['unidade_medida'] = $produto['unmedida'];
        $produto['foto_produto'] = $produto['imagem_produto'];
    }

} catch (PDOException $e) {
    echo "Erro ao buscar produtos: " . $e->getMessage();
}
?>