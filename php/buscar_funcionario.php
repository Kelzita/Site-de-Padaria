<?php
require_once 'conexao.php';
$funcionarios = [];

try {
    // Query base (ativos apenas)
    $sql = "SELECT f.*, func.nome_funcao 
            FROM funcionarios f
            LEFT JOIN funcao func ON f.id_funcao = func.id_funcao
            WHERE f.ativo = 1
            ORDER BY f.nome_funcionario ASC";

    if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty(trim($_POST['busca']))) {
        $busca = trim($_POST['busca']);

        if (is_numeric($busca)) {
            // Busca por ID exato
            $sql = "SELECT f.*, func.nome_funcao 
                    FROM funcionarios f
                    LEFT JOIN funcao func ON f.id_funcao = func.id_funcao
                    WHERE f.id_funcionario = :busca AND f.ativo = 1
                    ORDER BY f.nome_funcionario ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            // Busca por nome começando com o termo
            $sql = "SELECT f.*, func.nome_funcao 
                    FROM funcionarios f
                    LEFT JOIN funcao func ON f.id_funcao = func.id_funcao
                    WHERE f.nome_funcionario LIKE :busca_nome AND f.ativo = 1
                    ORDER BY f.nome_funcionario ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
        }
    } else {
        // Sem busca
        $stmt = $pdo->prepare($sql);
    }

    $stmt->execute();
    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao buscar funcionários: " . $e->getMessage();
}
?>
