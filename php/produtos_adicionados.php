<?php
session_start();
require_once 'conexao.php';

$id_comanda = $_SESSION['id_comanda'] ?? null;
if (!$id_comanda) {
    die("Nenhuma comanda ativa encontrada.");
}

// Buscar informações da comanda
$sql_comanda = "SELECT c.*, f.nome_funcionario 
                FROM comanda c 
                INNER JOIN funcionarios f ON c.id_funcionario = f.id_funcionario
                WHERE c.id_comanda = :id_comanda";
$stmt_comanda = $pdo->prepare($sql_comanda);
$stmt_comanda->execute([':id_comanda' => $id_comanda]);
$comanda = $stmt_comanda->fetch(PDO::FETCH_ASSOC);

// Busca itens da comanda
$sql = "SELECT 
            ic.id_item_comanda,
            ic.id_produto,
            ic.quantidade,
            ic.observacao,
            ic.total,
            p.nome_produto,
            p.preco,
            p.imagem_produto
        FROM item_comanda ic
        INNER JOIN produto p ON ic.id_produto = p.id_produto
        WHERE ic.id_comanda = :id_comanda";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_comanda' => $id_comanda]);
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular total da comanda
$total_comanda = 0;
foreach ($itens as $item) {
    $total_comanda += $item['total'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Itens da Comanda - Sistema de Comandas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
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
        max-width: 1200px;
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
    
    .btn {
        padding: 10px 15px;
        text-decoration: none;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
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
        background:#2a180c;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    
    .btn-danger {
        background:rgb(220, 20, 60);
        color: white;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
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
    
    .status-aberta {
        color: #4CAF50;
        font-weight: bold;
        padding: 5px 10px;
        background: #e8f5e9;
        border-radius: 20px;
        font-size: 0.9rem;
    }
    
    .itens-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .itens-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .itens-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .item-card {
        background: #f8f9fa;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s;
        border-left: 4px solid #3D2412;
    }
    
    .item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .item-image {
        height: 160px;
        width: 100%;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }
    
    .item-info {
        padding: 15px;
    }
    
    .item-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    
    .item-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 15px;
    }
    
    .detail-label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .detail-value {
        font-weight: 600;
    }
    
    .item-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #3D2412;
        margin-bottom: 15px;
        text-align: center;
    }
    
    .item-form {
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
    
    .item-actions {
        display: flex;
        gap: 8px;
        margin-top: 10px;
    }
    
    .btn-sm {
        padding: 6px 10px;
        font-size: 0.8rem;
        flex: 1;
    }
    
    .btn-quantity {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        padding: 0;
        border-radius: 5px;
        font-weight: bold;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
        grid-column: 1 / -1;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #dee2e6;
    }
    
    .total-section {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
    }
    
    .total-label {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }
    
    .total-value {
        font-size: 2rem;
        font-weight: bold;
        color: #3D2412;
    }
    
    @media (max-width: 768px) {
        .itens-grid {
            grid-template-columns: 1fr;
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
        
        .item-details {
            grid-template-columns: 1fr;
        }
        
        .item-actions {
            flex-direction: column;
        }
    }
  </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Itens da Comanda</h1>
        <a href="comanda.php" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Voltar para Comanda
        </a>
    </div>

    <div class="comanda-info">
        <div class="comanda-header">
            <div>
                <h2>Comanda: Nº <?= htmlspecialchars($id_comanda) ?></h2>
                <p><strong>Status:</strong> 
                    <span class="status-aberta">
                        <?= htmlspecialchars($comanda['status']) ?>
                    </span>
                </p>
                <p><strong>Data de abertura:</strong> <?= htmlspecialchars($comanda['data_abertura']) ?> às <?= htmlspecialchars($comanda['hora_abertura']) ?></p>
                <p><strong>Atendente:</strong> <?= htmlspecialchars($comanda['nome_funcionario']) ?></p>
            </div>
        </div>
    </div>

    <div class="itens-container">
        <div class="itens-header">
            <h2>Produtos Adicionados</h2>
            <span><?= count($itens) ?> ite<?= count($itens) !== 1 ? 'ns' : 'm' ?></span>
        </div>
        
        <div class="itens-grid">
            <?php if ($itens): ?>
                <?php foreach ($itens as $item): ?>
                <div class="item-card">
                    <?php if (!empty($item['imagem_produto'])): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($item['imagem_produto']) ?>" class="item-image" alt="Produto">
                    <?php else: ?>
                        <div class="item-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="font-size: 2.5rem; color: #ccc;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="item-info">
                        <h3 class="item-title"><?= htmlspecialchars($item['nome_produto']) ?></h3>
                        
                        <div class="item-details">
                            <div>
                                <div class="detail-label">Quantidade</div>
                                <div class="detail-value"><?= $item['quantidade'] ?></div>
                            </div>
                            <div>
                                <div class="detail-label">Preço Unitário</div>
                                <div class="detail-value">R$ <?= number_format($item['preco'], 2, ',', '.') ?></div>
                            </div>
                        </div>
                        
                        <div class="item-price">Total: R$ <?= number_format($item['total'], 2, ',', '.') ?></div>
                        
                        <form method="POST" action="atualizar_item.php" class="item-form">
                            <input type="hidden" name="id_item_comanda" value="<?= $item['id_item_comanda'] ?>">
                            
                            <div class="form-group">
                                <label for="observacao-<?= $item['id_item_comanda'] ?>">Observações:</label>
                                <textarea id="observacao-<?= $item['id_item_comanda'] ?>" name="observacao" class="form-control" placeholder="Ex: Sem cebola, ponto da carne, etc."><?= htmlspecialchars($item['observacao']) ?></textarea>
                            </div>
                            
                            <div class="item-actions">
                                <button type="submit" name="acao" value="diminuir" class="btn btn-secondary btn-sm btn-quantity" title="Diminuir quantidade">
                                    <i class="fas fa-minus"></i>
                                </button>
                                
                                <button type="submit" name="acao" value="aumentar" class="btn btn-primary btn-sm btn-quantity" title="Aumentar quantidade">
                                    <i class="fas fa-plus"></i>
                                </button>
                                
                                <button type="submit" name="acao" value="apagar" class="btn btn-danger btn-sm" title="Remover item" onclick="">
                                    <i class="fas fa-trash"></i>          Remover 
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Nenhum item adicionado</h3>
                    <p>Volte para a comanda para adicionar produtos</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($itens): ?>
    <div class="total-section">
        <div class="total-label">Total da Comanda</div>
        <div class="total-value">R$ <?= number_format($total_comanda, 2, ',', '.') ?></div>
    </div>
    <?php endif; ?>
</div>

<script>
    // Adicionar confirmação para ações de remoção
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('button[value="apagar"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Tem certeza que deseja remover este item da comanda?')) {
                    e.preventDefault();
                }
            });
        });
        
        // Adicionar efeito de loading nos botões
        const forms = document.querySelectorAll('.item-form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                if (submitBtn.value === "apagar") {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Removendo...';
                } else if (submitBtn.value === "aumentar") {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                } else if (submitBtn.value === "diminuir") {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                }
                
                submitBtn.disabled = true;
                
                // Reverter após 5 segundos (fallback caso a página não recarregue)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            });
        });
    });
</script>

</body>
</html>