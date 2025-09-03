<?php
session_start();
require_once("conexao.php");

//Verifica se o usuario tem permissao de adm
//if($_SESSION['id_funcao'] != 1) {
    //echo ("<script>alert('Acesso Negado! Retornando para a página inicial...'); window.location.href='../HTML/principal.php';");
//}


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

        <label for="nome_produto">Nome Produto:</label>
        <input type="text"  id="nome_produto"name="nome_produto" value="<?=htmlspecialchars($produto['nome_produto'])?>"required>

        <label for="descricao">Descrição:</label>
        <input type="text"  id="descricao" name="descricao" value="<?=htmlspecialchars($produto['descricao'])?>"required>

        <label for="preco">Valor_Unitario:</label>
        <input type="number"  id="preco" name="preco" value="<?=htmlspecialchars($produto['preco'])?>"required>

        <label for="quantidade_produto">Quantidade:</label>
        <input type="number"  id="quantidade_produto" name="quantidade_produto" value="<?=htmlspecialchars($produto['quantidade_produto'])?>"required>
       
        <label for="validade">Validade:</label>
        <input type="number"  id="validade" name="validade" value="<?=htmlspecialchars($produto['validade'])?>"required> 

        <button type="submit">Alterar</button>
        <button type="reset">Cancelar</button>
    </form>
    <?php endif; ?>
    <a href="principal.php">Voltar</a>
</body>
</html>