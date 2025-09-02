<?php
session_start();
require_once 'conexao.php';

$id_comanda = $_SESSION['id_comanda'] ?? null;
if (!$id_comanda) {
    die("Nenhuma comanda ativa encontrada.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_item_comanda'], $_POST['acao'])) {
    $id_item = (int)$_POST['id_item_comanda'];
    $acao = $_POST['acao'];
    $observacao = $_POST['observacao'] ?? '';

    // Pega quantidade atual e produto
    $sql = "SELECT quantidade, id_produto FROM item_comanda WHERE id_item_comanda = :id_item_comanda";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_item_comanda' => $id_item]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        $quantidade = (int)$item['quantidade'];
        $id_produto = $item['id_produto'];

        // Pega preço do produto
        $sql = "SELECT preco FROM produto WHERE id_produto = :id_produto";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_produto' => $id_produto]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        $preco = $produto['preco'] ?? 0;

        if ($acao === 'aumentar') $quantidade++;
        if ($acao === 'diminuir') $quantidade--;
        if ($acao === 'apagar') $quantidade = 0;

        if ($quantidade <= 0) {
            $sql = "DELETE FROM item_comanda WHERE id_item_comanda = :id_item_comanda";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_item_comanda' => $id_item]);
        } else {
            $total = $quantidade * $preco;
            $sql = "UPDATE item_comanda SET quantidade = :quantidade, total = :total, observacao = :observacao WHERE id_item_comanda = :id_item_comanda";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':quantidade' => $quantidade,
                ':total' => $total,
                ':observacao' => $observacao,
                ':id_item_comanda' => $id_item
            ]);
        }
    }
}

header("Location: produtos_adicionados.php");
exit;
