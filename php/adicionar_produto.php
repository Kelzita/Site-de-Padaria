<?php 
# Inicia a sessão de um usuário e(ou) retoma, permite o armazenamento de informações - status de login e entre outros.
session_start();

require_once 'conexao.php'; #Chama o arquivo que conecta-se ao banco

// ============= CAPTURANDO DADOS VIA GET =================

# Pega os valores via GET, se eles existirem, ou seja, o "id_comanda", "id_produto", "quantidade" e "observacao".
# Caso contrário, eles irão receber valor nulo ( NULL ) ou um padrão no caso da quantidade (=1).
$id_comanda   = $_GET['id_comanda'] ?? null; 
$id_produto   = $_GET['id_produto'] ?? null; 
$quantidade   = $_GET['quantidade'] ?? 1; 
$observacao   = $_GET['observacao'] ?? null; 

// ============= VERIFICANDO OS DADOS =================

# Aqui diz, se o id_comanda/id_produto está vazio ou nulo, ele irá trazer uma mensagem de erro em JSON.
# Isso permite que o front-end (JavaScript) trate o erro com clareza.
if(!$id_comanda) {
    echo json_encode(["erro" => "ID da comanda não informado!"], JSON_UNESCAPED_UNICODE);
    exit;
}

if(!$id_produto) {
    echo json_encode(["erro" => "Produto não informado!"], JSON_UNESCAPED_UNICODE);
    exit;
}

// ============= BUSCA SQL PELO PREÇO DO PRODUTO =================

# Cria-se uma variável $sql, que é lhe atribuída o comando de SELECT na tabela produto, ou seja, uma busca pelo preço.
$sql = "SELECT preco FROM produto WHERE id_produto = :id_produto";

# Após isso, utilizamos a variável $stmt = statement juntamente com o $pdo, para preparar a query de SELECT.
$stmt = $pdo->prepare($sql);

# Em seguida, executamos a query preparada, substituindo o placeholder :id_produto pelo valor atribuído na variável $id_produto
$stmt->execute(['id_produto' => $id_produto]);

# Depois de executarmos a busca, utilizamos o "fetch" para pegar o primeiro resultado da consulta.
# O modo FETCH_ASSOC faz com que o resultado venha como um array associativo.
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

// ============= VERIFICANDO OS DADOS =================
# Se não existir produto com o id_produto informado, ele retorna uma mensagem de erro em JSON.
if(!$produto) {
    echo json_encode(["erro" => "Produto não encontrado"], JSON_UNESCAPED_UNICODE);
    exit;
}

// ============= CÁLCULO =================
# pega o preço do produto através do array associativo, ou seja, atribui à variável preço, o valor do campo "preco".
$preco = $produto['preco'];

# Faz o cálculo com uma multiplicação, atribuindo à variável $total = $preco x $quantidade
$total = $preco * $quantidade;


// ============= INSERE ITENS NA COMANDA =================

# De mesma forma como nos módulos anteriores, nós atribuímos à variável $sql, um comando que INSERE na tabela item_comanda.
$sql = "INSERT INTO item_comanda (id_comanda, id_produto, quantidade, observacao, total)
        VALUES (:id_comanda, :id_produto, :quantidade, :observacao, :total)";

# Preparando a variável $sql com $stmt - Statement e $pdo
$stmt = $pdo->prepare($sql);

# Executa a query preparada, substituindo os placeholders pelos valores passados.
$stmt->execute([
    'id_comanda'   => $id_comanda,
    'id_produto'   => $id_produto,
    'quantidade'   => $quantidade,
    'observacao'   => $observacao,
    'total'        => $total
]);


// ============= RETORNA A LISTA ATUALIZADA DOS ITENS =================

# Fazemos um SELECT na tabela item_comanda com JOIN na tabela produto para trazer informações completas.
# Importante: aqui usamos o campo "i.total" salvo no banco (e não recalculado), para manter consistência.
$sql = "SELECT i.id_item_comanda AS id_item, i.id_comanda, 
               p.nome_produto, i.quantidade, 
               p.preco AS valor_unit, 
               i.total
        FROM item_comanda i
        JOIN produto p ON p.id_produto = i.id_produto
        WHERE i.id_comanda = :id_comanda";

# Prepara e executa a query
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_comanda' => $id_comanda]);

# Recupera todos os itens como array associativo
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

# Define o cabeçalho da resposta como JSON e retorna os itens
header("Content-Type: application/json; charset=utf-8");
echo json_encode($itens, JSON_UNESCAPED_UNICODE);

