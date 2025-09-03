<?php
session_start();
require_once("conexao.php");

$produtos = [];
$mensagem = "";

try {
    // Verificar se a conexão foi estabelecida
    if (!$pdo) {
        throw new Exception("Erro na conexão com o banco de dados.");
    }
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query base
    $sql = "SELECT p.*, f.razao_social AS fornecedor_nome 
            FROM produto p 
            LEFT JOIN fornecedores f ON p.id_fornecedor = f.id_fornecedor
            WHERE 1=1";
    
    $params = [];
    
    // Verificar se há uma busca
    if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['busca'])) {
        $busca = trim($_POST['busca']);
        
        if (is_numeric($busca)) {
            $sql .= " AND p.id_produto = :busca";
            $params[':busca'] = $busca;
        } else {
            $sql .= " AND p.nome_produto LIKE :busca_nome";
            $params[':busca_nome'] = '%' . $busca . '%';
        }
    }
    
    $sql .= " ORDER BY p.nome_produto ASC";
    
    $stmt = $pdo->prepare($sql);
    
    // Bind dos parâmetros
    foreach ($params as $key => $value) {
        if (is_numeric($value)) {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
    }
    
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Ajustes para JS/modal
    foreach ($produtos as &$produto) {
        // Ajuste para unidade_medida
        if (isset($produto['unmedida'])) {
            $produto['unmedida'] = $produto['unmedida'];
        } else if (!isset($produto['unmedida'])) {
            $produto['unmedida'] = 'Não informado';
        }

        // Ajuste para foto_produto
        if (isset($produto['imagem_produto'])) {
            $produto['foto_produto'] = $produto['imagem_produto'];
        } else if (!isset($produto['foto_produto'])) {
            $produto['foto_produto'] = null;
        }
        
        // Garantir que todos os campos tenham valores padrão
        $campos = ['nome_produto', 'descricao', 'preco', 'quantidade_produto', 'id_fornecedor'];
        foreach ($campos as $campo) {
            if (!isset($produto[$campo]) || empty($produto[$campo])) {
                $produto[$campo] = 'Não informado';
            }
        }
    }
    unset($produto); // Boa prática

} catch (PDOException $e) {
    $mensagem = "Erro ao buscar produtos: " . $e->getMessage();
} catch (Exception $e) {
    $mensagem = $e->getMessage();
}
?>
