<?php

require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && !empty($_GET['id_comanda']) && !empty($_GET['id_produto'])) {
    $id_comanda = $_GET['id_comanda'];
    $id_produto = $_GET['id_produto'];
    $quantidade = !empty($_GET['quantidade']) ? $_GET['quantidade'] : 1;

    // Verifica se o produto já está na comanda
    $sql = "SELECT quantidade FROM comanda_produtos WHERE id_comanda = :id_comanda AND id_produto = :id_produto";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_comanda', $id_comanda, PDO::PARAM_INT);
    $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Atualiza a quantidade
        $sqlUpdate = "UPDATE comanda_produtos SET quantidade = quantidade + :quantidade WHERE id_comanda = :id_comanda AND id_produto = :id_produto";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':id_comanda', $id_comanda, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
        $stmtUpdate->execute();
    } else {
        // Insere novo item
        $sqlInsert = "INSERT INTO item_comanda (id_comanda, id_produto, quantidade) VALUES (:id_comanda, :id_produto, :quantidade)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->bindParam(':id_comanda', $id_comanda, PDO::PARAM_INT);
        $stmtInsert->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
        $stmtInsert->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmtInsert->execute();
    }

    header("Location: caixa.php?id_comanda=" . $id_comanda);
    exit;
}
?>