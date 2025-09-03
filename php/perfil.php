<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_funcionario'])) {
    header("Location: ../index.php");
    exit();
}

$id_funcionario = $_SESSION['id_funcionario'];

// Busca dados atuais do funcionário
$sql = "SELECT nome_funcionario, email_funcionario, imagem_funcionario FROM funcionarios WHERE id_funcionario = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id_funcionario]);
$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    die("Funcionário não encontrado.");
}

$mensagem = '';

if (isset($_POST['alterar'])) {

    // ======== ALTERAR NOME ========
    $novo_nome = trim($_POST['nome_funcionario'] ?? '');
    if (!empty($novo_nome) && $novo_nome !== $funcionario['nome_funcionario']) {
        $sql = "UPDATE funcionarios SET nome_funcionario = :nome WHERE id_funcionario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $novo_nome,
            ':id' => $id_funcionario
        ]);
        $funcionario['nome_funcionario'] = $novo_nome;
        $_SESSION['nome_funcionario'] = $novo_nome;
    }

    // ======== ALTERAR SENHA ========
    $nova_senha = trim($_POST['senha_funcionario'] ?? '');
    if (!empty($nova_senha)) {
        $hash_senha = password_hash($nova_senha, PASSWORD_DEFAULT);
        $sql = "UPDATE funcionarios SET senha = :senha WHERE id_funcionario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':senha' => $hash_senha,
            ':id' => $id_funcionario
        ]);
    }

    // ======== ALTERAR FOTO ========
    if (isset($_FILES['imagem_funcionario']) && $_FILES['imagem_funcionario']['tmp_name'] != '') {
        if (!is_dir('../uploads')) {
            mkdir('../uploads', 0755, true);
        }

        $arquivo_tmp = $_FILES['imagem_funcionario']['tmp_name'];
        $nome_arquivo = '../uploads/' . uniqid() . '_' . $_FILES['imagem_funcionario']['name'];

        if (move_uploaded_file($arquivo_tmp, $nome_arquivo)) {
            $sql = "UPDATE funcionarios SET imagem_funcionario = :imagem WHERE id_funcionario = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':imagem' => $nome_arquivo,
                ':id' => $id_funcionario
            ]);
            $funcionario['imagem_funcionario'] = $nome_arquivo;
            $_SESSION['imagem_funcionario'] = $nome_arquivo;
        } else {
            $mensagem = "<p style='color:red;'>Erro ao enviar a foto.</p>";
        }
    }

    if (empty($mensagem)) {
        $mensagem = "<p style='color:green;'>Perfil atualizado com sucesso!</p>";
    }

    // Atualiza os dados do funcionário
    $sql = "SELECT nome_funcionario, imagem_funcionario FROM funcionarios WHERE id_funcionario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_funcionario]);
    $funcionario_atualizado = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($funcionario_atualizado) {
        $_SESSION['nome_funcionario'] = $funcionario_atualizado['nome_funcionario'];
        $_SESSION['imagem_funcionario'] = $funcionario_atualizado['imagem_funcionario'];
        $funcionario = $funcionario_atualizado;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Funcionário</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #333; }
        form { max-width: 400px; margin-top: 20px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input[type="text"], input[type="password"], input[type="file"] { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; padding: 10px 15px; background-color: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #218838; }
        img { margin-top: 10px; border-radius: 5px; }
        p { margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Perfil do Funcionário</h1>

    <?php if (!empty($funcionario['imagem_funcionario']) && file_exists($funcionario['imagem_funcionario'])): ?>
        <img src="<?= htmlspecialchars($funcionario['imagem_funcionario']) ?>" alt="Foto de perfil" width="150">
    <?php else: ?>
        <p>Sem foto</p>
    <?php endif; ?>

    <?= $mensagem ?>

    <form action="" method="post" enctype="multipart/form-data">
        <!-- Foto -->
        <label for="imagem_funcionario">Foto:</label>
        <input type="file" name="imagem_funcionario">

        <!-- Nome -->
        <label for="nome_funcionario">Nome:</label>
        <input type="text" name="nome_funcionario" value="<?= htmlspecialchars($funcionario['nome_funcionario']) ?>">

        <!-- Senha -->
        <label for="senha_funcionario">Nova Senha:</label>
        <input type="password" name="senha_funcionario">

        <button type="submit" name="alterar">Alterar</button>
    </form>
</body>
</html>
