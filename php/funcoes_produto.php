
<!-- Busca o Produto POR ID - Alteração! -->
<?php

function buscarProdutoPorId($id_produto) {
    global $pdo;
    
    try {
        $sql = "SELECT * FROM produto WHERE id_produto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_produto, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao buscar produto: " . $e->getMessage());
        return null;
    }
}

?>
