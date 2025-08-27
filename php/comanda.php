<?php
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);

    // VERIFICA SE A BUSCA É POR ID OU NOME
    if (is_numeric($busca)) {
        $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM produto WHERE nome_produto LIKE :busca_nome ORDER BY nome_produto ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
    }
} else {
    // BUSCA TODOS OS PRODUTOS
    $sql = "SELECT * FROM produto ORDER BY id_produto ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (!empty($produtos)): ?>
    <table class="table">
        <tr>
            <th>Imagem</th>
            <th>ID Produto</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço Unitário</th>
            <th>Unidade</th>
            <th>Validade</th>
            <th>Quantidade</th>
        </tr>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td>
                    <?php if (!empty($produto['imagem'])): ?>
                        <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="Produto" width="60">
                    <?php else: ?>
                        <span>Sem imagem</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($produto['id_produto']) ?></td>
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td><?= htmlspecialchars($produto['descricao']) ?></td>
                <td>R$ <?= number_format($produto['preco_unit'], 2, ',', '.') ?></td>
                <td><?= htmlspecialchars($produto['uni_medida']) ?></td>
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
