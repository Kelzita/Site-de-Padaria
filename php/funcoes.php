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