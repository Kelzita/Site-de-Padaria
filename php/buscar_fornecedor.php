<?php
// ==================== INÍCIO DO PHP ====================
if (session_status() == PHP_SESSION_NONE) session_start();
require_once '../php/conexao.php';
require_once '../php/menu.php';

if (!isset($_SESSION['id_funcao']) || $_SESSION['id_funcao'] != 1) {
    echo "<script>alert('Acesso Negado!');window.location.href='../inicio/home.php';</script>";
    exit;
}

//ARRAY
$fornecedores = [];

// ==================== BUSCA ====================
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);

    if (is_numeric($busca)) {
        $sql = "SELECT * FROM fornecedores WHERE id_fornecedor = :busca ORDER BY razao_social ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca', $busca, PDO::PARAM_INT);
    } else {

        $sql = "SELECT * FROM fornecedores WHERE LOWER(razao_social) LIKE LOWER(:busca_nome) ORDER BY razao_social ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
    }
} else {

    $sql = "SELECT * FROM fornecedores ORDER BY id_fornecedor ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
