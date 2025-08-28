<?php
session_start();
require_once 'conexao.php';

// Se já existe uma comanda aberta na sessão
$id_comanda = $_SESSION['id_comanda'] ?? null;

// Se houver produtos buscados na sessão, usa eles
if (isset($_SESSION['produtos'])) {
    $produtos = $_SESSION['produtos'];
    unset($_SESSION['produtos']); // limpa para não repetir na próxima vez
} else {
    // Caso contrário, busca todos os produtos
    $sql = "SELECT * FROM produto ORDER BY nome_produto ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Comanda</title>
  <link rel="stylesheet" href="css/stylecomanda3.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <header>
    <img src="img/logo_pg.png" alt="Logo da Padaria">
  </header>

  <div class="retangulo">
    <h2>Selecione os produtos</h2>

    <?php if (!empty($produtos)): ?>
        <div class="retangulo-conteudo">
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
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td>
                                <?php if (!empty($produto['imagem_produto'])): ?>
                                    <img src="<?= htmlspecialchars($produto['imagem_produto']) ?>" alt="Produto" width="60">
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
                                <!-- Formulário para adicionar item -->
                                <form method="post" action="processa_comanda.php" style="margin:0; display:flex; gap:5px; align-items:center;">
                                    <input type="hidden" name="id_comanda" value="<?= $id_comanda ?>">
                                    <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
                                    <input type="number" name="quantidade" value="1" min="1" style="width:60px;">
                                    <button type="submit" name="adicionar_item">Adicionar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>Nenhum produto encontrado.</p>
    <?php endif; ?>
  </div>
</body>
</html>
