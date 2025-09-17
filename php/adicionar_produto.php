<?php 
# Inicia a sessão de um usuário e(ou) retoma, permite o armazenamento de informações - status de login e entre outros.
session_start();

require_once 'conexao.php' #Chama o arquivo que conecta-se ao banco

// ============= CAPTURANDO DADOS VIA GET =================

# Pega o valor via GET, se ele existir, ou seja, o "id_comanda" na URL ele recebe o valor ex: "id_comanda=5", Caso contrário, ele irá receber valor nulo ( NULL)

$id_comanda = $_GET['id_comanda'] ?? null; 
$id_produto = $_GET['id_produto'] ?? null; 
$quantidade = $_GET['quantidade'] ?? 1; 
$observacao = $_GET['observacao'] ?? null; 

// ============= VERIFICANDO OS DADOS =================

# Aqui diz, se o id_comanda/id_produto está vazio ou nulo, ele irá trazer uma mensagem de erro através do "echo", mostrando que o id da comanda/produto não foi informado.
# Os valores podem ser NULOS, 0 , Ou uma simples string vazia " ", ele trará este erro, pois estas variáveis não são propensas a estarem vazias.
# A resposta é em JSON porque é o formato mais fácil e padrão para o front-end (JavaScript) entender e tratar o erro com maestria. 

if(!$id_comanda) {
    echo json_encode(["erro" => "ID da comanda não informado!"]);
    exit;
}

if(!$id_produto) {
    echo json_encode(["erro" => "Produto não informado!"]);
    exit;
}

// ============= BUSCA SQL PELO PREÇO DO PRODUTO =================

# Cria-se uma variável $sql, que é lhe atribuída o comando de SELECT na tabela produto, ou seja, uma busca.

$sql = "SELECT preco FROM produto WHERE id_produto = :id_produto";

# Após isso, utilizamos a variável $stmt = statement juntamente com o $pdo, para preparar a variável que tem o comando de SELECT, de modo que possamos evitar o SQL INJECTION

$stmt = $pdo->prepare($sql);

#Em seguida, executamos a "query" preparada pelo $stmt, substituindo o placeholder :id_produto pelo valor atribuido na variável $id_produto

$stmt->execute(['id_produto' => $id_produto]);

# Depois de executarmos a busca, utilizamos o "fetch" para pegar o primeiro resultado da consulta.
# O modo FETCH_ASSOC, faz com que o resultado venha como um "array associativo" (Chaves com nomes das colunas do banco, não números, apropriadamente dizendo).
# EX: id_produto => 5
#     nome_produto => Pão de Queijo
#     quantidade = > 10
# E assim vai! 

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

// ============= VERIFICANDO OS DADOS =================
# Se não existir produto com o id_produto que fora escolhido no banco de dados, ele retorna uma mensagem de erro, tratada por JSON, mostrando que o produto não foi encontrado
# O fetch retorna a falso, porém, neste caso ele trás uma mensagem de erro
if(!$produto) {
    echo json_encode(["erro" => "Produto não encontrado"]);
    exit;
}

// ============= CÁLCULO =================
# pega o preço do produto através de um array associativo, ou seja, atribuindo à variável preço, o $produto que tem o ID, e o preço dele. Caso seja R$5,00 o valor atribuido ao $preco será R$5,00. Depedendendo da quantiddade, ele irá multiplicar de acordo, como pode ser visto no outro comando.
$preco = $produto['preco'];

# Faz o cálculo com uma multiplicação, atribuindo à variável $total que o seu valor é a variável $preco vezes a $quantidade
# EX: R$5,00 x 2 = R$10,00 :)
$total = $preco * $quantidade;


// ============= INSERE ITENS NA COMANDA =================

# De mesma forma como nos módulos anteriores, nós atribuímos à variável $sql, um comando que INSERE na tabela item_comanda nos seguintes campos, com os valores sendo colocados com placeholder's para melhor segurança.
$sql = "INSERT INTO item_comanda (id_comanda, id_produto, quantidade, observacao, total)
        VALUES (:id_comanda, :id_produto, :quantidade, :observacao, :total)";


# Preparando a variável $sql com $stmt - Statement e $pdo ( retornar à l38 para mais clareza )

$stmt = $pdo->prepare($sql);

# Nessa parte, ele executa a query preparada, substituindo os placeholders (:id_produto, por exemplo) pelos valores passados de forma segura, inserindo ou atualizando os dados no banco.

$stmt->execute([
    'id_comanda' => $id_comanda,
    'id_produto' => $id_produto,
    'quantidade' => $quantidade,
    'observacao' => $observacao,
    'total' => $total
]);


// ============= RETORNA A LISTA ATUALZIADA DOS ITENS =================

# Mais uma vez... criamos a variável $sql, onde lhe atribuímos um SELECT ( BUSCAR NA TABELA ITEM_COMANDA ), Só que no caso à seguir, também fazemos um join na tabela produto.
# Explicando melhor esta query, Fazemos um select na tabela item_comanda e o apelidamos como "id_item" e também, pegamos o id da comanda como vemos. Logo mais, para sabermos que são de tabelas diferentes, colocamos o "i" ou o "p" à frente ( i = item_comanda e p = produto), pegamos o nome, quantidade e o preco, que está sendo apelidado por valor_unitário.
# Logo mais, fazemos um cálculo entre a quantidade x preco (i.quantidade e p.preco) desta forma, fazemos com que esse calculo seja o "total", apelidado por este parâmetro. 
# FROM item_comanda ( Claro, os que são desta tabela )
# JOIN produto, onde podemos utilizar o "p" para demonstrar a tabela pertencente, pegamos o id_produto que é "=" a ele mesmo ( para não haver repetições ) 
# WHERE o i.id_comanda = :id_comanda - Placeholder criado para melhor proteção, evitando SQL INJECTION!

$sql = "SELECT i.id_item_comanda AS id_item, i.id_comanda, 
               p.nome_produto, i.quantidade, 
               p.preco AS valor_unit, 
               (i.quantidade * p.preco) AS total
        FROM item_comanda i
        JOIN produto p ON p.id_produto = i.id_produto
        WHERE i.id_comanda = :id_comanda";

    
# Novamente, ele vai preparar a variável com o $stmt e o $pdo, para evitar SQL INJECTION

$stmt = $pdo->prepare($sql);


#Em seguida, executamos a "query" preparada pelo $stmt, substituindo o placeholder :id_comanda pelo valor atribuido na variável $id_comanda
$stmt->execute(['id_comanda' => $id_comanda]);

# Depois de executarmos a busca, utilizamos o "fetch" para pegar o primeiro resultado.
# Ele faz com que o resultado venha como um "array associativo" (Chaves com nomes das colunas do banco, não números).
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

# Converte o array php em $itens, para JSON em um formato em que o FRONT ( javascript ) entenda 
echo json_encode($itens, JSON_UNESCAPED_UNICODE);


