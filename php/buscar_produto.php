<?php
session_start();
require_once("conexao.php");

// if ($_SESSION["id_funcao"] != 1) {
//     echo "<script>alert('Acesso negado!'); window.location.href='../principal.php?id';</script>";
//     exit;
//}

$produtos = []; // Inicializa a variável para evitar erros

try {
    if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['busca'])) {
        $busca = trim($_POST['busca']);
        

        if (is_numeric($busca)) {
            $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_produto ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM produto WHERE nome_produto LIKE :busca_nome ORDER BY nome_produto ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
        }

    } else {
        $sql = "SELECT * FROM produto ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
    }

    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao buscar produtos: " . $e->getMessage();
    // log_error($e); // Opcional: você pode logar isso em um arquivo
}
?>
