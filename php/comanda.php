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

// Verificar se é uma requisição AJAX
$isAjax = isset($_POST['ajax']) || isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

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
    if ($isAjax) {
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
            $stmt->execute([':busca_nome' => "$busca%"]);
        }
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$produtos && !$isAjax){
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
$mostrar_comandas_abertas = isset($_GET['mostrar_comandas']) || isset($_POST['mostrar_comandas']);
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
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistema de Comandas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="../css/stylecomanda.css">
</head>
<body>

<div class="container">
    <div class="header">
        <a href="../inicio/home.php" class="btn btn-light voltar-btn">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
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
        <form id="search-form" action="comanda.php" method="POST">
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

<a href="../inicio/home.php"> 
    <img class="seta" src="../img/btn_voltar.png" title="Voltar">
</a>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../javascript/comanda_funcoes.js"></script>
</body>
</html>