<?php
session_start();
require_once 'conexao.php';

$id_comanda = $_SESSION['id_comanda'] ?? null;
if (!$id_comanda) {
    die("Nenhuma comanda ativa encontrada.");
}

// Busca itens da comanda
$sql = "SELECT 
            ic.id_item_comanda,
            ic.id_produto,
            ic.quantidade,
            ic.observacao,
            ic.total,
            p.nome_produto,
            p.preco
        FROM item_comanda ic
        INNER JOIN produto p ON ic.id_produto = p.id_produto
        WHERE ic.id_comanda = :id_comanda";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_comanda' => $id_comanda]);
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Comanda</title>
  <link rel="stylesheet" href="../css/styleprodutos_adicionados.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
<div class="retangulo">
<a href="../php/comanda.php" class="voltar"> 
        <img class="seta" src="../img/btn_voltar.png" title="seta">
</a>
    <h2>Itens da Comanda Nº<?= htmlspecialchars($id_comanda) ?></h2>
    <div class="retangulo-conteudo">
        <?php if ($itens): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                    <th>Observações</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itens as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nome_produto']) ?></td>
                    <td><?= $item['quantidade'] ?></td>
                    <td>R$ <?= number_format($item['preco'],2,',','.') ?></td>
                    <td>R$ <?= number_format($item['total'],2,',','.') ?></td>
                    <td>
                        <form method="POST" action="atualizar_item.php" class="form-quantidade">
                            <input type="hidden" name="id_item_comanda" value="<?= $item['id_item_comanda'] ?>">
                            <textarea name="observacao" class="observacoes"><?= htmlspecialchars($item['observacao']) ?></textarea>
                    </td>
                    <td>
                            <button type="submit" name="acao" value="diminuir" class="btn-remover">-</button>
                            <button type="submit" name="acao" value="aumentar" class="btn-adicionar">+</button>
                            <button type="submit" name="acao" value="apagar" class="btn-apagar btn-remover-item">🗑️</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
            <div class="voltar">
                <a class="voltar" href="comanda.php">Voltar</a>
            </div>
        <?php else: ?>
            <p>Nenhum item adicionado.</p>
        <?php endif; ?>
</div>
<script src="../javascript/validacao_comanda.js"></script>

</body>
</html>
