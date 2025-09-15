<?php
require_once 'conexao.php';
$funcionarios = [];

try {
    # ========== SELECT APENAS EM FUNCIONÁRIOS ATIVOS (SELECT DE "CATEGORIA") ==============
    $sql = "SELECT f.*, func.nome_funcao 
            FROM funcionarios f
            LEFT JOIN funcao func ON f.id_funcao = func.id_funcao
            WHERE f.ativo = 1
            ORDER BY f.nome_funcionario ASC";

# ========== PEGANDO OS DADOS VIA POST ==============
    if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty(trim($_POST['busca']))) {
        $busca = trim($_POST['busca']);

        if (is_numeric($busca)) {
            # ========== BUSCA POR ID ==============
            $sql = "SELECT f.*, func.nome_funcao 
                    FROM funcionarios f
                    LEFT JOIN funcao func ON f.id_funcao = func.id_funcao
                    WHERE f.id_funcionario = :busca AND f.ativo = 1
                    ORDER BY f.nome_funcionario ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            # ========== BUSCA POR NOME ==============
            $sql = "SELECT f.*, func.nome_funcao 
                    FROM funcionarios f
                    LEFT JOIN funcao func ON f.id_funcao = func.id_funcao
                    WHERE f.nome_funcionario LIKE :busca_nome AND f.ativo = 1
                    ORDER BY f.nome_funcionario ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR); // <--- aqui
        }
    } else {
        $stmt = $pdo->prepare($sql);
    }

    $stmt->execute();
    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao buscar funcionários: " . $e->getMessage();
}


# ========== FILTRO DE STATUS E BUSCA ==============
$statusFilter = isset($_POST['status']) && $_POST['status'] !== '' ? intval($_POST['status']) : null;
$busca = isset($_POST['busca']) ? trim($_POST['busca']) : '';

$sql = "SELECT * FROM funcionarios WHERE 1=1";
if($statusFilter !== null){
    $sql .= " AND ativo = :status";
}
if($busca !== ''){
    $sql .= " AND (id_funcionario LIKE :busca_id OR nome_funcionario LIKE :busca_nome)";
}

$stmt = $pdo->prepare($sql);

if($statusFilter !== null){
    $stmt->bindParam(':status', $statusFilter, PDO::PARAM_INT);
}
if($busca !== ''){
    $buscaParam = "$busca%";
    $stmt->bindParam(':busca_id', $buscaParam, PDO::PARAM_STR);
    $stmt->bindParam(':busca_nome', $buscaParam, PDO::PARAM_STR);
}

$stmt->execute();
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
