<?php
require_once 'conexao.php';

if (isset($_GET['id'])) {
    $id_funcionario = $_GET['id'];
    
    try {
        $sql = "SELECT imagem_funcionario FROM funcionarios WHERE id_funcionario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_funcionario, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && !empty($result['imagem_funcionario'])) {
            // Verifica se é um BLOB válido
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->buffer($result['imagem_funcionario']);
            
            if (strpos($mime_type, 'image/') === 0) {
                header("Content-Type: " . $mime_type);
                echo $result['imagem_funcionario'];
                exit;
            }
        }
        
        // Se não encontrar imagem, retorna imagem padrão
        header("Content-Type: image/png");
        readfile("../img/avatars/default_avatar.png");
        
    } catch (Exception $e) {
        header("Content-Type: image/png");
        readfile("../img/avatars/default_avatar.png");
    }
} else {
    header("Content-Type: image/png");
    readfile("../img/avatars/default_avatar.png");
}
?>