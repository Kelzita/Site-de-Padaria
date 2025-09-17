<?php
session_start();
require_once "conexao.php";

date_default_timezone_set('America/Sao_Paulo');

// Verifica se o funcionário está logado
if (!isset($_SESSION['id_funcionario'])) {
    header("Location: login.php");
    exit;
}

$id_funcionario = $_SESSION['id_funcionario'];

<<<<<<< Updated upstream
// Verificar se é uma requisição AJAX
$isAjax = isset($_POST['ajax']) || isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

=======
>>>>>>> Stashed changes
// Buscar informações do funcionário logado
$sql_funcionario = "SELECT nome_funcionario, imagem_funcionario FROM funcionarios WHERE id_funcionario = :id_funcionario";
$stmt_funcionario = $pdo->prepare($sql_funcionario);
$stmt_funcionario->execute([':id_funcionario' => $id_funcionario]);
$funcionario = $stmt_funcionario->fetch(PDO::FETCH_ASSOC);

// ==================== GERENCIAMENTO DE COMANDA ==================== //
// Verificar se temos uma ação específica para comanda
if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'nova_comanda':
            // Cria uma nova comanda
            $status = 'Aberta';
            $data_abertura = date('Y-m-d');
            $hora_abertura = date('H:i:s');

            $sql = "INSERT INTO comanda (id_funcionario, data_abertura, hora_abertura, status)
                    VALUES (:id_funcionario, :data_abertura, :hora_abertura, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_funcionario' => $id_funcionario,
                ':data_abertura'  => $data_abertura,
                ':hora_abertura'  => $hora_abertura,
                ':status'         => $status
            ]);

            $_SESSION['id_comanda'] = $pdo->lastInsertId();
            header("Location: comanda.php");
            exit;
            break;
            
        case 'alterar_comanda':
            // Alterar para uma comanda específica
            if (isset($_GET['id_comanda'])) {
                $_SESSION['id_comanda'] = $_GET['id_comanda'];
                header("Location: comanda.php");
                exit;
            }
            break;
            
        case 'fechar_comanda':
            // Fechar a comanda atual
            if (isset($_SESSION['id_comanda'])) {
                $sql = "UPDATE comanda SET status = 'Fechada', data_fechamento = :data_fechamento, 
                        hora_fechamento = :hora_fechamento WHERE id_comanda = :id_comanda";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_comanda' => $_SESSION['id_comanda'],
                    ':data_fechamento' => date('Y-m-d'),
                    ':hora_fechamento' => date('H:i:s')
                ]);
                
                // Criar nova comanda automaticamente
                $sql = "INSERT INTO comanda (id_funcionario, data_abertura, hora_abertura, status)
                        VALUES (:id_funcionario, :data_abertura, :hora_abertura, :status)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_funcionario' => $id_funcionario,
                    ':data_abertura'  => date('Y-m-d'),
                    ':hora_abertura'  => date('H:i:s'),
                    ':status'         => 'Aberta'
                ]);

                $_SESSION['id_comanda'] = $pdo->lastInsertId();
                header("Location: comanda.php");
                exit;
            }
            break;
            
        case 'cancelar_comanda':
            // Cancelar a comanda atual
            if (isset($_SESSION['id_comanda'])) {
                $sql = "UPDATE comanda SET status = 'Cancelada', data_fechamento = :data_fechamento, 
                        hora_fechamento = :hora_fechamento WHERE id_comanda = :id_comanda";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_comanda' => $_SESSION['id_comanda'],
                    ':data_fechamento' => date('Y-m-d'),
                    ':hora_fechamento' => date('H:i:s')
                ]);
                
                // Criar nova comanda automaticamente
                $sql = "INSERT INTO comanda (id_funcionario, data_abertura, hora_abertura, status)
                        VALUES (:id_funcionario, :data_abertura, :hora_abertura, :status)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_funcionario' => $id_funcionario,
                    ':data_abertura'  => date('Y-m-d'),
                    ':hora_abertura'  => date('H:i:s'),
                    ':status'         => 'Aberta'
                ]);

                $_SESSION['id_comanda'] = $pdo->lastInsertId();
                header("Location: comanda.php");
                exit;
            }
            break;
    }
}

// Verifica se a comanda da sessão ainda está aberta
$comanda_valida = false;
$comanda_atual = null;
if (isset($_SESSION['id_comanda'])) {
    $sql = "SELECT c.*, f.nome_funcionario 
            FROM comanda c 
            INNER JOIN funcionarios f ON c.id_funcionario = f.id_funcionario
            WHERE c.id_comanda = :id_comanda";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_comanda' => $_SESSION['id_comanda']]);
    $comanda_atual = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($comanda_atual) {
        $comanda_valida = ($comanda_atual['status'] == 'Aberta');
    }
}

// Se a comanda da sessão não existe ou não está aberta, buscar a última aberta
if (!$comanda_valida) {
    $sql = "SELECT id_comanda FROM comanda 
            WHERE id_funcionario = :id_funcionario AND status = 'Aberta' 
            ORDER BY id_comanda DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_funcionario' => $id_funcionario]);
    $ultima_comanda = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ultima_comanda) {
        $_SESSION['id_comanda'] = $ultima_comanda['id_comanda'];
        
        // Recarregar dados da comanda atual
        $sql = "SELECT c.*, f.nome_funcionario 
                FROM comanda c 
                INNER JOIN funcionarios f ON c.id_funcionario = f.id_funcionario
                WHERE c.id_comanda = :id_comanda";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_comanda' => $_SESSION['id_comanda']]);
        $comanda_atual = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Se não existir nenhuma aberta, cria uma nova
        $status = 'Aberta';
        $data_abertura = date('Y-m-d');
        $hora_abertura = date('H:i:s');

        $sql = "INSERT INTO comanda (id_funcionario, data_abertura, hora_abertura, status)
                VALUES (:id_funcionario, :data_abertura, :hora_abertura, :status)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_funcionario' => $id_funcionario,
            ':data_abertura'  => $data_abertura,
            ':hora_abertura'  => $hora_abertura,
            ':status'         => $status
        ]);

        $_SESSION['id_comanda'] = $pdo->lastInsertId();
        
        // Recarregar dados da comanda atual
        $sql = "SELECT c.*, f.nome_funcionario 
                FROM comanda c 
                INNER JOIN funcionarios f ON c.id_funcionario = f.id_funcionario
                WHERE c.id_comanda = :id_comanda";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_comanda' => $_SESSION['id_comanda']]);
        $comanda_atual = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$id_comanda = $_SESSION['id_comanda'];

// ==================== ADICIONAR ITEM ==================== //
if (isset($_POST['adicionar_item'])) {
    $id_produto = $_POST['id_produto'];
    $quantidade = $_POST['quantidade'];
    $observacao = $_POST['observacoes'] ?? '';

    $sql = "SELECT preco FROM produto WHERE id_produto = :id_produto";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_produto' => $id_produto]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    $total = $produto['preco'] * $quantidade;

    $sql = "INSERT INTO item_comanda (id_comanda, id_produto, quantidade, observacao, total) 
            VALUES (:id_comanda, :id_produto, :quantidade, :observacao, :total)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_comanda' => $id_comanda,
        ':id_produto' => $id_produto,
        ':quantidade' => $quantidade,
        ':observacao' => $observacao,
        ':total' => $total
    ]);

    // Se for uma requisição AJAX, retornar JSON
<<<<<<< Updated upstream
    if ($isAjax) {
=======
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
>>>>>>> Stashed changes
        echo json_encode(['success' => true]);
        exit;
    } else {
        header("Location: comanda.php");
        exit;
    }
}

// ==================== BUSCA DE PRODUTOS ==================== //
$produtos = [];
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['busca'])) {
    $busca = trim($_POST['busca']);
    if ($busca !== "") {
        if (is_numeric($busca)) {
            $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_produto ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':busca' => $busca]);
        } else {
            $sql = "SELECT * FROM produto WHERE nome_produto LIKE :busca_nome ORDER BY nome_produto ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':busca_nome' => "%$busca%"]);
        }
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

<<<<<<< Updated upstream
        if(!$produtos && !$isAjax){
=======
        if(!$produtos){
>>>>>>> Stashed changes
            echo "<script>alert('Produto não encontrado!');</script>";
        }
    }
}

if (empty($produtos)) {
    $sql = "SELECT * FROM produto ORDER BY id_produto ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ==================== BUSCAR COMANDA ABERTAS ==================== //
$comandas_abertas = [];
<<<<<<< Updated upstream
$mostrar_comandas_abertas = isset($_GET['mostrar_comandas']) || isset($_POST['mostrar_comandas']);
=======
$mostrar_comandas_abertas = isset($_GET['mostrar_comandas']);
>>>>>>> Stashed changes
$busca_comanda = isset($_POST['busca_comanda']) ? trim($_POST['busca_comanda']) : '';

if ($mostrar_comandas_abertas) {
    $sql = "SELECT c.*, f.nome_funcionario, 
                   (SELECT SUM(total) FROM item_comanda WHERE id_comanda = c.id_comanda) as total_comanda
            FROM comanda c 
            INNER JOIN funcionarios f ON c.id_funcionario = f.id_funcionario
            WHERE c.status = 'Aberta'";
    
    $params = [];
    
    // Adicionar filtro de busca se existir
    if (!empty($busca_comanda)) {
        if (is_numeric($busca_comanda)) {
            $sql .= " AND c.id_comanda = :busca_comanda";
            $params[':busca_comanda'] = $busca_comanda;
        } else {
            $sql .= " AND f.nome_funcionario LIKE :busca_comanda";
            $params[':busca_comanda'] = "%$busca_comanda%";
        }
    }
    
    $sql .= " ORDER BY c.id_comanda DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $comandas_abertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ==================== CALCULAR TOTAL DA COMANDA ATUAL ==================== //
$total_comanda = 0;
if (isset($comanda_atual)) {
    $sql = "SELECT SUM(total) as total FROM item_comanda WHERE id_comanda = :id_comanda";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_comanda' => $id_comanda]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_comanda = $result['total'] ?? 0;
<<<<<<< Updated upstream
}

// Se for uma requisição AJAX, retornar apenas o conteúdo necessário
if ($isAjax) {
    if (isset($_POST['busca_comanda'])) {
        // Retornar apenas a seção de comandas
        ob_start();
        ?>
        <div id="comandas-resultados">
            <?php if (!empty($comandas_abertas)): ?>
                <div class="comandas-list">
                    <?php foreach ($comandas_abertas as $comanda): ?>
                    <div class="comanda-card">
                        <h3>Comanda #<?= $comanda['id_comanda'] ?></h3>
                        <p><strong>Atendente:</strong> <?= $comanda['nome_funcionario'] ?></p>
                        <p><strong>Data:</strong> <?= $comanda['data_abertura'] ?></p>
                        <p><strong>Total:</strong> R$ <?= number_format($comanda['total_comanda'] ?? 0, 2, ',', '.') ?></p>
                        
                        <div class="comanda-actions">
                            <a href="produtos_adicionados.php?id_comanda=<?= $comanda['id_comanda'] ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i> Ver Itens
                            </a>
                            
                            <?php if ($comanda['id_comanda'] != $id_comanda): ?>
                            <a href="comanda.php?acao=alterar_comanda&id_comanda=<?= $comanda['id_comanda'] ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Usar
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-receipt"></i>
                    <h3>Nenhuma comanda encontrada</h3>
                    <p><?= !empty($busca_comanda) ? 'Tente ajustar os termos da sua pesquisa' : 'Todas as comandas estão fechadas no momento' ?></p>
                </div>
            <?php endif; ?>
        </div>
        <?php
        $content = ob_get_clean();
        echo $content;
        exit;
    }
    
    // Para outras requisições AJAX (como pesquisa de produtos)
    if (isset($_POST['busca'])) {
        // Retornar apenas a seção de produtos
        ob_start();
        ?>
        <div id="products-container">
            <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                <div class="product-card">
                    <?php if (!empty($produto['imagem_produto'])): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($produto['imagem_produto']) ?>" class="product-image" alt="Produto">
                    <?php else: ?>
                        <div class="product-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="font-size: 3rem; color: #ccc;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="product-info">
                        <h3 class="product-title"><?= htmlspecialchars($produto['nome_produto']) ?></h3>
                        <div class="product-price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></div>
                        
                        <form method="POST" action="comanda.php" class="product-form" onsubmit="addItemToComanda(event, this)">
                            <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
                            
                            <div class="form-group">
                                <label for="quantidade-<?= $produto['id_produto'] ?>">Quantidade:</label>
                                <input type="number" id="quantidade-<?= $produto['id_produto'] ?>" name="quantidade" min="1" value="1" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="observacoes-<?= $produto['id_produto'] ?>">Observações:</label>
                                <textarea id="observacoes-<?= $produto['id_produto'] ?>" name="observacoes" class="form-control" placeholder="Ex: Sem cebola, ponto da carne, etc."></textarea>
                            </div>
                            
                            <button type="submit" name="adicionar_item" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Adicionar à Comanda
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h3>Nenhum produto encontrado</h3>
                    <p>Tente ajustar os termos da sua pesquisa</p>
                </div>
            <?php endif; ?>
        </div>
        <?php
        $content = ob_get_clean();
        echo $content;
        exit;
    }
=======
>>>>>>> Stashed changes
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistema de Comandas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
<<<<<<< Updated upstream
/* botão voltar */

=======
>>>>>>> Stashed changes
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
        background-color: #f8f9fa;
        color: #333;
        padding: 20px;
        background-image: url('../img/fundo_padaria.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }
    
    .container {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #000;
    }
    
    .comanda-info {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-left: 5px solid #000;
    }
    
    .comanda-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .btn {
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-primary {
        background: #3D2412;
        color: white;
    }
    
    .btn-primary:hover {
        background: #2a180c;
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background: #3D2412;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #2a180c;
        transform: translateY(-2px);
    }
    
    .btn-danger {
        background: #000;
        color: white;
    }
    
    .btn-danger:hover {
        background: #333;
        transform: translateY(-2px);
    }
    
    .btn-warning {
<<<<<<< Updated upstream
        background:rgb(17, 14, 4);
        color: #fff;

    }
    
    .btn-warning:hover {
        background:rgb(0, 0, 0);
=======
        background: #ffc107;
        color: #000;
    }
    
    .btn-warning:hover {
        background: #e0a800;
>>>>>>> Stashed changes
        transform: translateY(-2px);
    }
    
    .btn-light {
        background: #f8f9fa;
        color: #333;
        border: 1px solid #ddd;
    }
    
    .btn-light:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }
    
    .status-aberta {
        color: #4CAF50;
        font-weight: bold;
        padding: 5px 10px;
        background: #e8f5e9;
        border-radius: 20px;
        font-size: 0.9rem;
    }
    
    .search-box {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .search-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        margin-bottom: 15px;
    }
    
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .product-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }
    
    .product-image {
        height: 180px;
        width: 100%;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }
    
    .product-info {
        padding: 15px;
    }
    
    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    
    .product-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #3D2412;
        margin-bottom: 15px;
    }
    
    .product-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .form-group label {
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .form-control {
        padding: 8px 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    
    textarea.form-control {
        min-height: 60px;
        resize: vertical;
    }
    
    .comandas-section {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-top: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .comanda-search-box {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    
    .comanda-search-input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .comandas-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .comanda-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        border-left: 4px solid #3D2412;
    }
    
    .comanda-card h3 {
        margin-bottom: 10px;
        color: #333;
    }
    
    .comanda-card p {
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    
    .comanda-actions {
        margin-top: 10px;
        display: flex;
        gap: 8px;
    }
    
    .btn-sm {
        padding: 6px 10px;
        font-size: 0.8rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #dee2e6;
    }
    
    .comanda-count {
        background: #3D2412;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        margin-left: 10px;
    }
    
    .loading {
        display: none;
        text-align: center;
        padding: 20px;
    }
    
<<<<<<< Updated upstream
    .loading-comandas {
        display: none;
        text-align: center;
        padding: 20px;
    }
    
=======
>>>>>>> Stashed changes
    .loading-spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3D2412;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
        
        .header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .comanda-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
        
        .comanda-search-box {
            flex-direction: column;
        }
    }
  </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Comanda</h1>
        <div class="user-info">
            <?php if (!empty($funcionario['imagem_funcionario'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($funcionario['imagem_funcionario']) ?>" class="user-avatar" alt="Avatar">
            <?php else: ?>
                <div class="user-avatar" style="background: #3D2412; color: white; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user"></i>
                </div>
            <?php endif; ?>
            <span><?= htmlspecialchars($funcionario['nome_funcionario']) ?></span>
        </div>
    </div>

    <div class="comanda-info">
        <div class="comanda-header">
            <div>
                <h2>Comanda Atual: Nº <?= htmlspecialchars($id_comanda) ?></h2>
                <p><strong>Status:</strong> 
                    <span class="status-aberta">
                        <?= htmlspecialchars($comanda_atual['status']) ?>
                    </span>
                </p>
                <p><strong>Data de abertura:</strong> <?= htmlspecialchars($comanda_atual['data_abertura']) ?> às <?= htmlspecialchars($comanda_atual['hora_abertura']) ?></p>
                <p><strong>Atendente:</strong> <?= htmlspecialchars($comanda_atual['nome_funcionario']) ?></p>
                <p><strong>Total:</strong> R$ <?= number_format($total_comanda, 2, ',', '.') ?></p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="comanda.php?acao=nova_comanda" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nova Comanda
                </a>
                <a href="produtos_adicionados.php?id_comanda=<?= $id_comanda ?>" class="btn btn-secondary">
                    <i class="fas fa-shopping-cart"></i> Ver Itens
                </a>
                <?php if ($comanda_atual && $comanda_atual['status'] == 'Aberta'): ?>
                <a href="comanda.php?acao=fechar_comanda" class="btn btn-danger">
                    <i class="fas fa-lock"></i> Fechar Comanda
                </a>
                <a href="comanda.php?acao=cancelar_comanda" class="btn btn-warning" onclick="return confirm('Tem certeza que deseja cancelar esta comanda?')">
                    <i class="fas fa-times"></i> Cancelar Comanda
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="search-box">
<<<<<<< Updated upstream
        <form id="search-form" action="comanda.php" method="POST">
=======
        <form id="search-form" action="#" method="POST">
>>>>>>> Stashed changes
            <input type="text" class="search-input" name="busca" id="busca-input" placeholder="Digite o nome ou ID do produto..." value="<?= isset($_POST['busca']) ? htmlspecialchars($_POST['busca']) : '' ?>">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Pesquisar Produto
            </button>
            <button type="button" id="clear-search" class="btn btn-light" style="display: none;">
                <i class="fas fa-times"></i> Limpar
            </button>
        </form>
    </div>

    <div class="loading">
        <div class="loading-spinner"></div>
        <p>Carregando produtos...</p>
    </div>

    <div class="products-grid" id="products-container">
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
            <div class="product-card">
                <?php if (!empty($produto['imagem_produto'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($produto['imagem_produto']) ?>" class="product-image" alt="Produto">
                <?php else: ?>
                    <div class="product-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-image" style="font-size: 3rem; color: #ccc;"></i>
                    </div>
                <?php endif; ?>
                
                <div class="product-info">
                    <h3 class="product-title"><?= htmlspecialchars($produto['nome_produto']) ?></h3>
                    <div class="product-price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></div>
                    
                    <form method="POST" action="comanda.php" class="product-form" onsubmit="addItemToComanda(event, this)">
                        <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
                        
                        <div class="form-group">
                            <label for="quantidade-<?= $produto['id_produto'] ?>">Quantidade:</label>
                            <input type="number" id="quantidade-<?= $produto['id_produto'] ?>" name="quantidade" min="1" value="1" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="observacoes-<?= $produto['id_produto'] ?>">Observações:</label>
                            <textarea id="observacoes-<?= $produto['id_produto'] ?>" name="observacoes" class="form-control" placeholder="Ex: Sem cebola, ponto da carne, etc."></textarea>
                        </div>
                        
                        <button type="submit" name="adicionar_item" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Adicionar à Comanda
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h3>Nenhum produto encontrado</h3>
                <p>Tente ajustar os termos da sua pesquisa</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="comandas-section">
        <div class="section-header">
            <h2>Comandas Abertas 
                <?php if ($mostrar_comandas_abertas && !empty($comandas_abertas)): ?>
                    <span class="comanda-count"><?= count($comandas_abertas) ?></span>
                <?php endif; ?>
            </h2>
            <a href="comanda.php?mostrar_comandas=1" class="btn btn-light">
                <i class="fas fa-sync"></i> Atualizar
            </a>
        </div>
        
        <?php if ($mostrar_comandas_abertas): ?>
<<<<<<< Updated upstream
            <form id="comanda-search-form" method="POST" class="comanda-search-box">
                <input type="text" class="comanda-search-input" name="busca_comanda" id="busca-comanda-input" 
                       placeholder="Buscar por número da comanda ou nome do atendente..." 
                       value="<?= htmlspecialchars($busca_comanda) ?>">
                <button type="button" id="buscar-comandas-btn" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
                <input type="hidden" name="mostrar_comandas" value="1">
            </form>
            
            <div class="loading-comandas">
                <div class="loading-spinner"></div>
                <p>Buscando comandas...</p>
            </div>
            
            <div id="comandas-resultados">
                <?php if (!empty($comandas_abertas)): ?>
                    <div class="comandas-list">
                        <?php foreach ($comandas_abertas as $comanda): ?>
                        <div class="comanda-card">
                            <h3>Comanda #<?= $comanda['id_comanda'] ?></h3>
                            <p><strong>Atendente:</strong> <?= $comanda['nome_funcionario'] ?></p>
                            <p><strong>Data:</strong> <?= $comanda['data_abertura'] ?></p>
                            <p><strong>Total:</strong> R$ <?= number_format($comanda['total_comanda'] ?? 0, 2, ',', '.') ?></p>
                            
                            <div class="comanda-actions">
                                <a href="produtos_adicionados.php?id_comanda=<?= $comanda['id_comanda'] ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-eye"></i> Ver Itens
                                </a>
                                
                                <?php if ($comanda['id_comanda'] != $id_comanda): ?>
                                <a href="comanda.php?acao=alterar_comanda&id_comanda=<?= $comanda['id_comanda'] ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Usar
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-receipt"></i>
                        <h3>Nenhuma comanda encontrada</h3>
                        <p><?= !empty($busca_comanda) ? 'Tente ajustar os termos da sua pesquisa' : 'Todas as comandas estão fechadas no momento' ?></p>
                    </div>
                <?php endif; ?>
            </div>
=======
            <form method="POST" action="comanda.php?mostrar_comandas=1" class="comanda-search-box">
                <input type="text" class="comanda-search-input" name="busca_comanda" placeholder="Buscar por número da comanda ou nome do atendente..." value="<?= htmlspecialchars($busca_comanda) ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
            
            <?php if (!empty($comandas_abertas)): ?>
                <div class="comandas-list">
                    <?php foreach ($comandas_abertas as $comanda): ?>
                    <div class="comanda-card">
                        <h3>Comanda #<?= $comanda['id_comanda'] ?></h3>
                        <p><strong>Atendente:</strong> <?= $comanda['nome_funcionario'] ?></p>
                        <p><strong>Data:</strong> <?= $comanda['data_abertura'] ?></p>
                        <p><strong>Total:</strong> R$ <?= number_format($comanda['total_comanda'] ?? 0, 2, ',', '.') ?></p>
                        
                        <div class="comanda-actions">
                            <a href="produtos_adicionados.php?id_comanda=<?= $comanda['id_comanda'] ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i> Ver Itens
                            </a>
                            
                            <?php if ($comanda['id_comanda'] != $id_comanda): ?>
                            <a href="comanda.php?acao=alterar_comanda&id_comanda=<?= $comanda['id_comanda'] ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Usar
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-receipt"></i>
                    <h3>Nenhuma comanda encontrada</h3>
                    <p><?= !empty($busca_comanda) ? 'Tente ajustar os termos da sua pesquisa' : 'Todas as comandas estão fechadas no momento' ?></p>
                </div>
            <?php endif; ?>
>>>>>>> Stashed changes
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <h3>Comandas não carregadas</h3>
                <p>Clique no botão "Atualizar" para ver as comandas abertas</p>
                <a href="comanda.php?mostrar_comandas=1" class="btn btn-primary" style="margin-top: 15px;">
                    <i class="fas fa-sync"></i> Carregar Comandas
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Função para adicionar item à comanda via AJAX
    function addItemToComanda(event, form) {
        event.preventDefault();
        
        // Mostrar loading
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adicionando...';
        submitBtn.disabled = true;
        
        // Coletar todos os dados do formulário
        const formData = new FormData(form);
        formData.append('adicionar_item', 'true'); // Adicionar o nome do botão
        formData.append('ajax', 'true');
        
        fetch('comanda.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Feedback visual de sucesso
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Adicionado!';
                submitBtn.style.background = '#4CAF50';
                
                // Restaurar botão após 2 segundos
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.style.background = '';
                    submitBtn.disabled = false;
                    
                    // Resetar quantidade para 1
                    form.querySelector('input[name="quantidade"]').value = 1;
                    
                    // Limpar observações
                    form.querySelector('textarea[name="observacoes"]').value = '';
                }, 2000);
            } else {
                throw new Error('Falha ao adicionar item');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            submitBtn.innerHTML = '<i class="fas fa-times"></i> Erro';
            submitBtn.style.background = '#f44336';
            
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.style.background = '';
                submitBtn.disabled = false;
            }, 2000);
            
            alert('Erro ao adicionar item. Tente novamente.');
        });
    }

<<<<<<< Updated upstream
=======
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
>>>>>>> Stashed changes
    // Adicionar funcionalidade de pesquisa em tempo real para produtos
    document.addEventListener('DOMContentLoaded', function() {
        const buscaInput = document.getElementById('busca-input');
        const clearSearchBtn = document.getElementById('clear-search');
        const searchForm = document.getElementById('search-form');
        const productsContainer = document.getElementById('products-container');
        const loadingElement = document.querySelector('.loading');
        
        // Mostrar botão de limpar se houver texto na busca
<<<<<<< Updated upstream
        if (buscaInput && buscaInput.value) {
=======
        if (buscaInput.value) {
>>>>>>> Stashed changes
            clearSearchBtn.style.display = 'inline-flex';
        }
        
        // Evento para o botão de limpar busca
<<<<<<< Updated upstream
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function() {
                buscaInput.value = '';
                clearSearchBtn.style.display = 'none';
                searchForm.submit();
            });
        }
        
        // Evento para mudanças no input de busca
        if (buscaInput) {
            buscaInput.addEventListener('input', function() {
                if (this.value) {
                    clearSearchBtn.style.display = 'inline-flex';
                } else {
                    clearSearchBtn.style.display = 'none';
                }
                
                // Pesquisa em tempo real com AJAX
                const searchTerm = this.value.toLowerCase();
                
                // Mostrar loading
                loadingElement.style.display = 'block';
                productsContainer.style.opacity = '0.5';
                
                // Fazer requisição AJAX
                const formData = new FormData();
                formData.append('busca', searchTerm);
                formData.append('ajax', 'true');
                
                fetch('comanda.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(html => {
                    // Atualizar apenas a seção de produtos
                    productsContainer.innerHTML = html;
=======
        clearSearchBtn.addEventListener('click', function() {
            buscaInput.value = '';
            clearSearchBtn.style.display = 'none';
            searchForm.submit();
        });
        
        // Evento para mudanças no input de busca
        buscaInput.addEventListener('input', function() {
            if (this.value) {
                clearSearchBtn.style.display = 'inline-flex';
            } else {
                clearSearchBtn.style.display = 'none';
            }
            
            // Pesquisa em tempo real com AJAX
            const searchTerm = this.value.toLowerCase();
            
            // Mostrar loading
            loadingElement.style.display = 'block';
            productsContainer.style.opacity = '0.5';
            
            // Fazer requisição AJAX
            $.ajax({
                url: 'comanda.php',
                method: 'POST',
                data: {
                    busca: searchTerm,
                    ajax: true
                },
                success: function(response) {
                    // Extrair apenas a parte dos produtos da resposta
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(response, 'text/html');
                    const newProducts = doc.getElementById('products-container');
                    
                    if (newProducts) {
                        productsContainer.innerHTML = newProducts.innerHTML;
                    }
>>>>>>> Stashed changes
                    
                    // Reaplicar eventos aos formulários
                    document.querySelectorAll('.product-form').forEach(form => {
                        form.onsubmit = function(e) {
                            addItemToComanda(e, this);
                        };
                    });
                    
                    // Esconder loading
                    loadingElement.style.display = 'none';
                    productsContainer.style.opacity = '1';
<<<<<<< Updated upstream
                })
                .catch(error => {
                    console.error('Erro:', error);
=======
                },
                error: function() {
>>>>>>> Stashed changes
                    // Esconder loading em caso de erro
                    loadingElement.style.display = 'none';
                    productsContainer.style.opacity = '1';
                    alert('Erro ao buscar produtos. Tente novamente.');
<<<<<<< Updated upstream
                });
            });
        }
        
        // Adicionar funcionalidade de pesquisa AJAX para comandas
        const comandaSearchForm = document.getElementById('comanda-search-form');
        const buscarComandasBtn = document.getElementById('buscar-comandas-btn');
        const buscaComandaInput = document.getElementById('busca-comanda-input');
        const comandasResultados = document.getElementById('comandas-resultados');
        const loadingComandas = document.querySelector('.loading-comandas');
        
        if (buscarComandasBtn && comandaSearchForm) {
            buscarComandasBtn.addEventListener('click', function() {
                buscarComandas();
            });
            
            // Também permitir pesquisa ao pressionar Enter
            buscaComandaInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    buscarComandas();
                }
            });
        }
        
        function buscarComandas() {
            const buscaTerm = buscaComandaInput.value;
            
            // Mostrar loading
            loadingComandas.style.display = 'block';
            comandasResultados.style.opacity = '0.5';
            
            // Fazer requisição AJAX
            const formData = new FormData();
            formData.append('busca_comanda', buscaTerm);
            formData.append('mostrar_comandas', '1');
            formData.append('ajax', 'true');
            
            fetch('comanda.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // Atualizar apenas a seção de comandas
                comandasResultados.innerHTML = html;
                
                // Esconder loading
                loadingComandas.style.display = 'none';
                comandasResultados.style.opacity = '1';
            })
            .catch(error => {
                console.error('Erro:', error);
                // Esconder loading em caso de erro
                loadingComandas.style.display = 'none';
                comandasResultados.style.opacity = '1';
                alert('Erro ao buscar comandas. Tente novamente.');
            });
        }
    });
=======
                }
            });
        });
        
        // Filtrar produtos localmente também (fallback)
        function filtrarProdutos(searchTerm) {
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(card => {
                const productName = card.querySelector('.product-title').textContent.toLowerCase();
                const productId = card.querySelector('input[name="id_produto"]').value;
                
                if (productName.includes(searchTerm) || productId.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    });
    
    // Função para adicionar item à comanda via AJAX
    function addItemToComanda(event, form) {
        event.preventDefault();
        
        // Mostrar loading
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adicionando...';
        submitBtn.disabled = true;
        
        // Fazer requisição AJAX
        const formData = new FormData(form);
        
        fetch('comanda.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Feedback visual de sucesso
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Adicionado!';
                submitBtn.style.background = '#4CAF50';
                
                // Restaurar botão após 2 segundos
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.style.background = '';
                    submitBtn.disabled = false;
                    
                    // Resetar quantidade para 1
                    form.querySelector('input[name="quantidade"]').value = 1;
                    
                    // Limpar observações
                    form.querySelector('textarea[name="observacoes"]').value = '';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            alert('Erro ao adicionar item. Tente novamente.');
        });
    }
>>>>>>> Stashed changes
</script>
</body>
</html>