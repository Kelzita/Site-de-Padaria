<?php
session_start();
require_once 'conexao.php';

// Cria nova comanda
if (!isset($_SESSION['id_comanda'])) {
    date_default_timezone_set('America/Sao_Paulo'); //Fuso horario
    $status = 'Aberta';
    $data_abertura = date('Y-m-d');
    $hora_abertura = date('H:i:s');
    $id_funcionario = $_SESSION['id_funcionario'] ?? 1;

    $sql = "INSERT INTO comanda (id_funcionario, data_abertura, hora_abertura, status)
            VALUES (:id_funcionario, :data_abertura, :hora_abertura, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_funcionario' => $id_funcionario,
        ':data_abertura'  => $data_abertura,
        ':hora_abertura'  => $hora_abertura,
        ':status'         => $status
    ]);

    $_SESSION['id_comanda'] = $pdo->lastInsertId();
}

$id_comanda = $_SESSION['id_comanda'];

// Busca produtos
$produtos = [];
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['busca'])) {
    $busca = trim($_POST['busca']);
    if ($busca !== "") {
        if (is_numeric($busca)) {
            $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_produto ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':busca' => $busca]);
        } else {
            $sql = "SELECT * FROM produto WHERE nome_produto LIKE :busca_nome ORDER BY nome_produto ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':busca_nome' => "%$busca%"]);
        }
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$produtos){
            echo "<script>alert('Produto não encontrado!');window.location.href='comanda.php';</script>";
    }
    }
}

if (empty($produtos)) {
    $sql = "SELECT * FROM produto ORDER BY id_produto ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Adiciona item
if (isset($_POST['adicionar_item'])) {
    $id_comanda = $_SESSION['id_comanda'] ?? null;
    $id_produto = $_POST['id_produto'];
    $quantidade = $_POST['quantidade'];

    if ($id_comanda) {
        $sql = "SELECT preco FROM produto WHERE id_produto = :id_produto";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_produto' => $id_produto]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        $total = $produto['preco'] * $quantidade;

        $sql = "INSERT INTO item_comanda (id_comanda, id_produto, quantidade, total) 
                VALUES (:id_comanda, :id_produto, :quantidade, :total)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_comanda' => $id_comanda,
            ':id_produto' => $id_produto,
            ':quantidade' => $quantidade,
            ':total' => $total
        ]);
    }

    header("Location: comanda.php");
    exit;
}

// Enviar para o caixa
if (isset($_POST['finalizar_venda'])) {
    $id_comanda = $_SESSION['id_comanda'] ?? null;
    $forma_pagamento = $_POST['forma_pagamento'] ?? 'Não especificado';

    if ($id_comanda) {
        $sql = "UPDATE comanda 
                SET status = 'Finalizada', forma_pagamento = :pagamento
                WHERE id_comanda = :id_comanda";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':pagamento' => $forma_pagamento,
            ':id_comanda' => $id_comanda
        ]);

        // Limpa a sessão para criar nova comanda
        unset($_SESSION['id_comanda']);
    }

    header("Location: comanda.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Comanda</title>
  <link rel="stylesheet" href="../css/stylecomanda3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
<header>
    <img src="../img/logo_pg.png" alt="Logo da Padaria">
</header>

<div class="retangulo">
    <a href="../entrada_comanda.html" class="voltar"> 
        <img class="seta" src="../img/btn_voltar.png" title="seta">
    </a>
    <div class="carrinho">
    <a href="produtos_adicionados.php" class="produtos_adicionados">
        <img class="carrinho" src="../img/carrinho.png" title="carrinho">
    </a>
    </div>
    <h2>Comanda Nº <?= htmlspecialchars($id_comanda) ?></h2>
        <form action="comanda.php" method="POST">
            <input type="text" id="busca" name="busca" placeholder="Buscar produto...">
            <button type="submit">Pesquisar</button>
        </form>
    <div class="retangulo-conteudo">
        <?php if (!empty($produtos)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>ID Produto</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço Unitário</th>
                    <th>Unidade</th>
                    <th>Validade</th>
                    <th>Quantidade</th>
                    <th>Observações</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td>
                        <?php if (!empty($produto['imagem_produto'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($produto['imagem_produto']) ?>" alt="Produto" width="60">
                        <?php else: ?>
                            <span>Sem imagem</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($produto['id_produto']) ?></td>
                    <td><?= htmlspecialchars($produto['nome_produto']) ?></td>
                    <td><?= htmlspecialchars($produto['descricao']) ?></td>
                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($produto['unmedida']) ?></td>
                    <td><?= htmlspecialchars($produto['validade']) ?></td>
                    <td>
                        <form method="POST" action="comanda.php">
                            <input type="hidden" name="id_comanda" value="<?= $id_comanda ?>">
                            <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
                            <input type="number" name="quantidade" value="1" min="1" class="input-quantidade">
                    </td>
                    <td>
                        <textarea class="observacoes" rows="1" cols="20" placeholder="Observações"></textarea>
                    </td>
                    <td>
                        <button type="submit" name="adicionar_item" class="btn-adicionar">+</button>
                    </td>
                    </form>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
        <form method="POST" action="comanda.php">
            <input type="hidden" name="finalizar_venda" value="1">
            <button type="submit" class="finalizar_venda">Enviar para o caixa</button>
        </form>
        <?php else: ?>
            <p>Nenhum produto encontrado.</p>
        <?php endif; ?>
</div>
</body>
</html>
