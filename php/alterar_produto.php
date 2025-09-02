<?php
session_start();
require_once("conexao.php");


//inicializa variaveis
$produto = null;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['busca_produto'])){
        $busca = trim($_POST['busca_produto']);

        //verifica se a busca e um numero (id) ou um nome
        if(is_numeric($busca)){
            $sql = "SELECT * FROM produto WHERE id_produto = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);
        }else{
            $sql = "SELECT * FROM produto WHERE nome_produto LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"$busca%",PDO::PARAM_STR);
        }

        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        //Se o produto nao for encontrado, exibe um alerta
        if(!$produto){
            echo "<script>alert('Produto nao encontrado');</script>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Produto</title>
    <link rel="stylesheet" href="styles.css">
    <!-- certifique-se que o javascript esta sendo carregado corretamente -->
    <script src="scripts.js"></script>
</head>
<body>

    <h2>Alterar Produto</h2>

    <form action="alterar_produto.php" method="POST">
        <label for="busca_produto">Digite o nome do produto</label>
        <input type="text" id="busca_produto" name="busca_produto" required onkeyup="buscarSugestoes()">
        
        <!-- div para exibir sugestoes de usuarios -->
        <div id="sugestoes"></div>
        <button type="submit">Buscar</button>
</form>

<?php if($produto):?>
    <!-- formulario para alterar produto -->
    <form action="processa_alteracao_produto.php" method="POST">
        <input type="hidden" name="id_produto" value="<?=htmlspecialchars($produto['id_produto'])?>">

        <label for="nome_produto"><i class="fas fa-barcode"></i> Nome do Produto:</label>
            <input type="text" id="nome_produto" name="nome_produto" placeholder="Insira o nome do produto" >

            <label for="descricao"><i class="ri-file-text-line"></i> Descrição:</label>
            <textarea id="descricao" name="descricao" placeholder="Insira uma descrição (Opcional)" ></textarea>

            <label for="preco"><i class="fas fa-dollar-sign"></i> Preço:</label>
            <input type="number" step="0.01" id="preco" name="preco" placeholder="R$ 0,00" >

            <label for="unmedida"><i class="fas fa-cube"></i> Unidade de Medida:</label>
            <input type="text" id="unmedida" name="unmedida" placeholder="Ex: Kg, un, L" >
            <div class="input-group">
            
            <label for="quantidade"><i class="fas fa-boxes"></i> Quantidade do Produto:</label>
            <input type="number" id="quantidade_produto"  name="quantidade_produto"  placeholder="Digite a quantidade disponível" min="1" >
            
            <label for="validade"><i class="fas fa-calendar-alt"></i> Validade:</label>
            <input type="date" id="validade" name="validade" >

            
            <label for="id_fornecedor"><i class="fas fa-truck"></i> Fornecedor:</label>
            <select name="id_fornecedor" id="id_fornecedor" >
                <option value="">Selecione o fornecedor</option>
                <?php foreach ($fornecedores as $fornecedor): ?>
                    <option value="<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>" 
                    <?= $fornecedor['id_fornecedor'] == $idSelecionadoFornecedor ? 'selected' : '' ?>>
                 <?= htmlspecialchars($fornecedor['id_fornecedor']), ' - ' ,htmlspecialchars($fornecedor['razao_social']) ?>
            </option>
            <?php endforeach; ?>
            </select>

            <label for="imagem_produto"><i class="fa-solid fa-image"></i> Foto do Produto:</label>
            <input type="file"name="imagem_produto" id="imagem_produto" required></input>

            <input type="hidden" name="id_estoque" id="id_estoque" >


            <button type="submit" class="btn-cadastrar"><i class="fas fa-save"></i> Cadastrar</button>
        </form>
    </div>
    <script src="../js/validacao_cad_produto.js"></script>
  
       
        
        <button type="submit">Alterar</button>
        <button type="reset">Cancelar</button>
    </form>
    <?php endif; ?>
    <a href="principal.php">Voltar</a>
</body>
</html>