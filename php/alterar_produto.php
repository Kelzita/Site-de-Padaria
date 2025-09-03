<?php
session_start();
require_once("conexao.php");

// Verifica se o usuário tem permissão de adm
// if($_SESSION['id_funcao'] != 1) {
//    echo ("<script>alert('Acesso Negado! Retornando para a página inicial...'); window.location.href='../HTML/principal.php';");
//}

// inicializa variáveis
$produto = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['busca_produto'])) {
        $busca = trim($_POST['busca_produto']);

        // verifica se a busca é um número (id) ou um nome
        if (is_numeric($busca)) {
            $sql = "SELECT * FROM produto WHERE id_produto = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM produto WHERE nome_produto LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
        }

        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se o produto não for encontrado, exibe um alerta
        if (!$produto) {
            echo "<script>alert('Produto não encontrado');</script>";
        }
    }
}

// Função para formatar a data para o padrão yyyy-mm-dd do input date
function formatarDataParaInput($data)
{
    if (!$data) return '';
    // Tenta criar um DateTime e formatar
    $dt = DateTime::createFromFormat('Y-m-d', $data);
    if ($dt) {
        return $dt->format('Y-m-d');
    }
    // Se não estiver no padrão, tenta converter de outros formatos (exemplo: d/m/Y)
    $dt = DateTime::createFromFormat('d/m/Y', $data);
    if ($dt) {
        return $dt->format('Y-m-d');
    }
    return ''; // vazio se não conseguir formatar
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Alterar Produto</title>
    <link rel="stylesheet" href="../css/alterar.css" />
    <script src="scripts.js"></script>
</head>

<body>

    <h2 class="modal-editar__titulo">Alterar Produto</h2>




    <?php if ($produto): ?>
    <!-- formulário para alterar produto -->
    <form action="processa_alteracao_produto.php" method="POST" class="formulario-funcionario modal-editar__container">

        <input type="hidden" name="id_produto" value="<?= htmlspecialchars($produto['id_produto']) ?>" />

        <div class="grupo-formulario">
            <label for="nome_produto" class="rotulo-formulario">Nome Produto:</label>
            <input type="text" id="nome_produto" name="nome_produto"
                value="<?= htmlspecialchars($produto['nome_produto']) ?>" required class="entrada-formulario" />
        </div>

        <div class="grupo-formulario">
            <label for="descricao" class="rotulo-formulario">Descrição:</label>
            <input type="text" id="descricao" name="descricao" value="<?= htmlspecialchars($produto['descricao']) ?>"
                required class="entrada-formulario" />
        </div>

        <div class="grupo-formulario">
            <label for="preco" class="rotulo-formulario">Valor Unitário:</label>
            <input type="number" step="0.01" id="preco" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>"
                required class="entrada-formulario" />
        </div>

        <div class="grupo-formulario">
            <label for="quantidade_produto" class="rotulo-formulario">Quantidade:</label>
            <input type="number" id="quantidade_produto" name="quantidade_produto"
                value="<?= htmlspecialchars($produto['quantidade_produto']) ?>" required class="entrada-formulario" />
        </div>

        <!-- NOVO CAMPO unmedida -->
        <div class="grupo-formulario">
            <label for="unmedida" class="rotulo-formulario">Unidade de Medida:</label>
            <input type="text" id="unmedida" name="unmedida"
                value="<?= isset($produto['unmedida']) ? htmlspecialchars($produto['unmedida']) : '' ?>"
                required class="entrada-formulario" />
        </div>

        <div class="grupo-formulario" style="display: flex; align-items: center; gap: 0.5rem;">
            <label for="validade" class="rotulo-formulario" style="flex-shrink: 0;">Validade:</label>
            <input type="date" id="validade" name="validade"
                value="<?= formatarDataParaInput($produto['validade']) ?>" required class="entrada-formulario"
                style="flex-grow: 1;" />
            <span style="font-size: 0.9rem; color: #444;">(data)</span>
        </div>

        <div class="acoes-formulario grupo-formulario grupo-formulario--completo">
            <button type="submit" class="botao botao--primario">Alterar</button>
            <button type="reset" class="botao botao--secundario">Cancelar</button>
        </div>
    </form>
    <?php endif; ?>

    <a href="principal.php" class="botao botao--secundario" style="margin-top:1rem; display:inline-block;">Voltar</a>
</body>

</html>
