<?php
require 'conexao.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id > 0){
    $sql = "SELECT imagem_produto FROM produto WHERE id_produto = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto && !empty($produto['imagem_produto'])) {
        $imagem = $produto['imagem_produto'];

        // Detecta o tipo da imagem
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($imagem);

        header("Content-Type: $mime");
        echo $imagem;
        exit;
    }
}

// Imagem padrão
header("Content-Type: image/png");
readfile("../img/imagem_padrao.png");
exit;
?>
