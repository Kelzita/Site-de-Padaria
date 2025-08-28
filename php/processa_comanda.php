<?php
session_start();
require_once 'conexao.php';


// ===== CRIAR COMANDA =====
if (isset($_POST['criar_comanda'])) {
    $status = $_POST['status'] ?? 'Aberta';
    $data_abertura = date('Y-m-d');
    $hora_abertura = date('H:i:s');


    $sql = "INSERT INTO comanda (id_funcionario, data_abertura, hora_abertura, status) VALUES (:id_funcionario, :data_abertura, :hora_abertura, :status)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id_funcionario',$id_funcionario);
    $stmt->bindParam(':data_abertura',$data_abertura);
    $stmt->bindParam(':hora_abertura',$hora_abertura);
    $stmt->bindParam(':status',$status);


    // Substitua pelo ID do funcionário logado, se tiver
    $id_funcionario = 1;

    // Salvar ID da comanda na sessão
    $_SESSION['id_comanda'] = $pdo->lastInsertId();


    header("Location: comanda.php");
    exit;
}


// ===== ADICIONAR ITEM =====
if (isset($_POST['adicionar_item'])) {
    $id_comanda = $_POST['id_comanda'];
    $id_produto = $_POST['id_produto'];
    $quantidade = $_POST['quantidade'];


    // Buscar preço unitário do produto
    $sql = "SELECT preco FROM produto WHERE id_produto = :id_produto";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_produto' => $id_produto]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);


    $total = $produto['preco'] * $quantidade;


    // Inserir na tabela item_comanda
    $sql = "INSERT INTO item_comanda (id_comanda, id_produto, quantidade, total) VALUES (:id_comanda, :id_produto, :quantidade, :total)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_comanda' => $id_comanda,
        ':id_produto' => $id_produto,
        ':quantidade' => $quantidade,
        ':total' => $total
    ]);


    header("Location: comanda.php");
    exit;
}


// ===== BUSCAR PRODUTO =====
if (isset($_POST['buscar_produto']) && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);
    if (is_numeric($busca)) {
        $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':busca' => $busca]);
    } else {
        $sql = "SELECT * FROM produto WHERE nome_produto LIKE :busca_nome ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':busca_nome' => "%$busca%"]);
    }


    // Guardar resultados na sessão para exibir em comanda.php
    $_SESSION['produtos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);


    header("Location: comanda.php");
    exit;
}
