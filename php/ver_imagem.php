<?php
session_start();
require_once 'conexao.php';

$nome = $_GET['img'] ?? 'default.png';

// Ajuste o caminho conforme a pasta uploads real
$caminho = __DIR__ . '/../uploads/' . basename($nome);

if (!file_exists($caminho) || empty($nome)) {
    $caminho = __DIR__ . '/../uploads/default.png';
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$tipo = finfo_file($finfo, $caminho);
finfo_close($finfo);

header("Content-Type: $tipo");
readfile($caminho);
exit;
