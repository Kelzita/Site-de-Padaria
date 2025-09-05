<?php
session_start();
require_once '../php/conexao.php';

if (!isset($_SESSION['id_funcionario'])) {
    header("Location: login.php");
    exit;
}

$id_funcionario = $_SESSION['id_funcionario'];

// Recebe dados do formulário
$senha_atual = $_POST['senha_atual'] ?? '';
$nova_senha = $_POST['nova_senha'] ?? '';
$conf_senha = $_POST['conf_senha'] ?? '';
$imagem = $_FILES['imagem_funcionario'] ?? null;

// Busca a senha atual no banco
$stmt = $pdo->prepare("SELECT senha FROM funcionarios WHERE id_funcionario = :id");
$stmt->bindParam(':id', $id_funcionario, PDO::PARAM_INT);
$stmt->execute();
$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    echo "<script>alert('Funcionário não encontrado!'); window.history.back();</script>";
    exit;
}

// Verifica senha atual (opcional)
if (!empty($senha_atual) && !password_verify($senha_atual, $funcionario['senha'])) {
    echo "<script>alert('Senha atual incorreta!'); window.history.back();</script>";
    exit;
}

// Valida nova senha (opcional)
if (!empty($nova_senha)) {
    if ($nova_senha !== $conf_senha) {
        echo "<script>alert('Nova senha e confirmação não conferem!'); window.history.back();</script>";
        exit;
    }
    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
} else {
    $senha_hash = $funcionario['senha']; // mantém a senha atual
}

// Trata a imagem (se enviada)
$imagem_bin = null;
if ($imagem && $imagem['error'] === 0) {
    $imagem_bin = file_get_contents($imagem['tmp_name']);
}

// Atualiza no banco
if ($imagem_bin !== null) {
    $sql = "UPDATE funcionarios SET senha = :senha, imagem_funcionario = :imagem WHERE id_funcionario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':imagem', $imagem_bin, PDO::PARAM_LOB);
} else {
    $sql = "UPDATE funcionarios SET senha = :senha WHERE id_funcionario = :id";
    $stmt = $pdo->prepare($sql);
}

$stmt->bindParam(':senha', $senha_hash);
$stmt->bindParam(':id', $id_funcionario, PDO::PARAM_INT);
$stmt->execute();

// Atualiza a sessão com a nova imagem
if ($imagem_bin !== null) {
    $_SESSION['imagem_funcionario'] = $imagem_bin; // salva binário
}

echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href='../inicio/home.php';</script>";
?>