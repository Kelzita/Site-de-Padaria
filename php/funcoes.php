<?php 
require_once 'conexao.php';

//busca as funções cadastradas no banco
$sql = "SELECT * FROM funcao";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$funcoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ID da função selecionada (se estiver editando um funcionário)
$idSelecionado = isset($funcionario['id_funcao']) ? $funcionario['id_funcao'] : null;
?>


<!-- SELECT DOS FORNECEDORES -->
<?php 
require_once 'conexao.php';

$sql = "SELECT * FROM fornecedores";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// se estiver editando, pegue o id do fornecedor do registro
$idSelecionadoFornecedor = isset($produto['id_fornecedor']) ? $produto['id_fornecedor'] : null;
?>

<!-- Busca o Funcionário POR ID  - Alteração! -->
<?php

function buscarFuncionarioPorId($id_funcionario) {
    global $pdo;
    
    try {
        $sql = "SELECT f.*, fn.nome_funcao 
                FROM funcionarios f 
                LEFT JOIN funcao fn ON f.id_funcao = fn.id_funcao 
                WHERE f.id_funcionario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_funcionario, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao buscar funcionário: " . $e->getMessage());
        return null;
    }
}

?>

<!-- Busca o Produto POR ID - Alteração! -->
<?php

function buscarProdutoPorId($id_produto) {
    global $pdo;
    
    try {
        $sql = "SELECT * FROM produto WHERE id_produto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_produto, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao buscar produto: " . $e->getMessage());
        return null;
    }
}

?>

<?php
require_once 'conexao.php';

// Buscar fornecedor por ID
function buscarFornecedorPorId($id_fornecedor){
    global $pdo;
    try {
        $sql = "SELECT * FROM fornecedores WHERE id_fornecedor = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_fornecedor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        error_log("Erro ao buscar fornecedor: ".$e->getMessage());
        return null;
    }
}

// Listar todos os fornecedores
function listarFornecedores(){
    global $pdo;
    try {
        $sql = "SELECT * FROM fornecedores ORDER BY id_fornecedor DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        error_log("Erro ao listar fornecedores: ".$e->getMessage());
        return [];
    }
}

// Inativar/Ativar fornecedor
function toggleFornecedor($id){
    global $pdo;
    try{
        $fornecedor = buscarFornecedorPorId($id);
        if(!$fornecedor) return ['sucesso'=>false];

        $novoStatus = $fornecedor['ativo'] ? 0 : 1;
        $sql = "UPDATE fornecedores SET ativo = :ativo WHERE id_fornecedor = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ativo', $novoStatus, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return ['sucesso'=>true, 'ativo'=>$novoStatus];
    } catch(PDOException $e){
        error_log("Erro ao alterar status fornecedor: ".$e->getMessage());
        return ['sucesso'=>false];
    }
}
?>