<?php
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);

    // Busca por ID
    if (is_numeric($busca)) {
        $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        // Busca por nome
        $sql = "SELECT * FROM produto WHERE nome_produto LIKE :busca_nome ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
    }
} else {
    // Todos os produtos
    $sql = "SELECT * FROM produto ORDER BY id_produto ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (!empty($produtos)): ?>
    <table class="table" border="1">
        <tr>
            <th>Imagem</th>
            <th>ID Produto</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Unidade</th>
            <th>Validade</th>
            <th>Quantidade</th>
        </tr>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td>
                    <?php if (!empty($produto['imagem_produto'])): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($produto['imagem_produto']) ?>" 
                             alt="Produto" width="60">
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
                    <input type="number" name="quantidade[<?= $produto['id_produto'] ?>]" value="1" min="1" style="width:60px;">
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Nenhum produto encontrado.</p>
<?php endif; ?>
<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['id_comanda'])) {
    $id_comanda = $_POST['id_comanda'];

    $sql = "SELECT p.id_produto, p.nome_produto, p.preco_unit, c.quantidade 
            FROM comanda_produtos c
            JOIN produto p ON c.id_produto = p.id_produto
            WHERE c.id_comanda = :id_comanda";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_comanda', $id_comanda, PDO::PARAM_INT);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $produtos = [];
}