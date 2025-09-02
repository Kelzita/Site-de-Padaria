<?php
session_start(); 
require_once "conexao.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(["erro" => "ID da comanda não informado"]);
    exit;
}

// checa se a comanda existe e se está aberta
$sql = "SELECT status FROM comanda WHERE id_comanda = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$comanda = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comanda) {
    echo json_encode(["erro" => "Comanda não encontrada"]);
    exit;
}

if (strtolower($comanda['status']) !== 'aberta') {
    echo json_encode(["erro" => "Esta comanda já foi fechada!"]);
    exit;
}

$_SESSION['id_comanda'] = $id; // salva na sessão

// pega os itens da comanda
$sql = "SELECT i.id_item_comanda AS id_item, i.id_comanda, 
               p.nome_produto, i.quantidade, 
               p.preco AS valor_unit, 
               (i.quantidade * p.preco) AS total
        FROM item_comanda i
        JOIN produto p ON p.id_produto = i.id_produto
        WHERE i.id_comanda = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// **Retorna somente o array de itens**
echo json_encode($dados);
?>
