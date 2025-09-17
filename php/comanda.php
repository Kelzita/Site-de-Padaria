<?php
session_start();
require_once "conexao.php";

date_default_timezone_set('America/Sao_Paulo');
$id_funcionario = $_SESSION['id_funcionario'] ?? 1;

// ==================== GERENCIAMENTO DE COMANDA ==================== //
// Verifica se a comanda da sessão ainda está aberta
$comanda_valida = false;
if (isset($_SESSION['id_comanda'])) {
    $sql = "SELECT id_comanda FROM comanda 
            WHERE id_comanda = :id_comanda AND status = 'Aberta'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_comanda' => $_SESSION['id_comanda']]);
    $comanda_valida = $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
}

// Se a comanda da sessão não existe ou não está aberta, buscar a última aberta
if (!$comanda_valida) {
    $sql = "SELECT id_comanda FROM comanda 
            WHERE id_funcionario = :id_funcionario AND status = 'Aberta' 
            ORDER BY id_comanda DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_funcionario' => $id_funcionario]);
    $ultima_comanda = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ultima_comanda) {
        $_SESSION['id_comanda'] = $ultima_comanda['id_comanda'];
    } else {
        // Se não existir nenhuma aberta, cria uma nova
        $status = 'Aberta';
        $data_abertura = date('Y-m-d');
        $hora_abertura = date('H:i:s');

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
}

$id_comanda = $_SESSION['id_comanda'];

// ==================== ADICIONAR ITEM ==================== //
if (isset($_POST['adicionar_item'])) {
    $id_produto = $_POST['id_produto'];
    $quantidade = $_POST['quantidade'];
    $observacao = $_POST['observacoes'] ?? '';

    $sql = "SELECT preco FROM produto WHERE id_produto = :id_produto";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_produto' => $id_produto]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    $total = $produto['preco'] * $quantidade;

    $sql = "INSERT INTO item_comanda (id_comanda, id_produto, quantidade, observacao, total) 
            VALUES (:id_comanda, :id_produto, :quantidade, :observacao, :total)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_comanda' => $id_comanda,
        ':id_produto' => $id_produto,
        ':quantidade' => $quantidade,
        ':observacao' => $observacao,
        ':total' => $total
    ]);

    header("Location: comanda.php");
    exit;
}

// ==================== BUSCA DE PRODUTOS ==================== //
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
            $stmt->execute([':busca_nome' => "$busca%"]);
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

// ==================== ENVIAR PARA O CAIXA ==================== //
if (isset($_POST['enviar_caixa'])) {
    // NÃO altera o status da comanda atual (permanece Aberta)
    // Cria nova comanda automaticamente
    $status = 'Aberta';
    $data_abertura = date('Y-m-d');
    $hora_abertura = date('H:i:s');

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

<div class="retangulo">
  <div class="topo-retangulo">
    <a href="../inicio/home.php" class="voltar"> 
      <img class="seta" src="../img/btn_voltar.png" title="seta">
    </a>
    <a href="produtos_adicionados.php" class="produtos_adicionados">
      <img class="carrinho" src="../img/carrinho.png" title="carrinho">
    </a>
  </div>

  <h2>Comanda Nº <?= htmlspecialchars($id_comanda) ?></h2>

  <!-- Formulário de busca -->
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
                          <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
                          <input type="number" name="quantidade" min="1" class="input-quantidade">
                  </td>
                  <td>
                      <textarea name="observacoes" class="observacoes" rows="1" cols="20" placeholder="Observações"></textarea>
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

  <!-- Botão enviar para o caixa -->
  <form method="POST" action="comanda.php">
      <button type="submit" name="enviar_caixa" class="finalizar_venda">Enviar para o caixa</button>
  </form>

  <?php else: ?>
      <p>Nenhum produto encontrado.</p>
  <?php endif; ?>
</div>

<script src="../javascript/validacao_comanda.js"></script>
</body>
</html>

