<?php 
session_start();
require_once 'conexao.php';
require_once 'menu.php';

//Verifica se o usuário tem permissão de adm,secretária ou almoxarife.

if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2 && $_SESSION['perfil'] != 3) {
    echo "<script>alert('Acesso negado!'); window.location.href='principal.php'</script>";
    exit();
}
$fornecedor = []; //Inicializando a variável
//Se o formulário for enviado, busca o usuário por ID OU NOME

if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);

    //Verifica se a busca é um número ou nome
    if(is_numeric($busca)) {
        $sql =  "SELECT * FROM fornecedor WHERE id_fornecedor = :busca ORDER BY nome_fornecedor ASC"; //BUSCA POR ID

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    
    }else {
        $sql = "SELECT *  FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome ORDER BY nome_fornecedor ASC "; // Faz  por nome.
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome',"%$busca%", PDO::PARAM_STR);
    }

} else {
    $sql = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC"; 
    $stmt = $pdo->prepare($sql);
}
$stmt->execute();
$fornecedores = $stmt->fetchALL(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Fornecedor</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="tabela.css">
</head>
<body>
    <h2>Lista de Fornecedores</h2>
    <form action="buscar_fornecedor.php" method="POST">
        <label for="busca">Digite o ID ou Nome(Opcional):</label>
        <input type="text" id="busca" name="busca"/>
        <button type="submit">Buscar</button>
    </form>
    <?php if(!empty($fornecedores)) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Contato</th>
                <th>Ações</th>
            </tr>

            <?php foreach($fornecedores as $fornecedor) : ?>
            <tr>
                <td><?=htmlspecialchars($fornecedor['id_fornecedor']);?></td>
                <td><?=htmlspecialchars($fornecedor['nome_fornecedor']);?></td>
                <td><?=htmlspecialchars($fornecedor['endereco']);?></td>
                <td><?=htmlspecialchars($fornecedor['telefone']);?></td>
                <td><?=htmlspecialchars($fornecedor['email']);?></td>
                <td><?=htmlspecialchars($fornecedor['contato']);?></td>
                <td>
                    <a href="alterar_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor']); ?>">Alterar</a>

                    <a href="excluir_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor']); ?>" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')">Excluir</a>
            </td>
            </tr>
            <?php endforeach ?>
        <table>
        <?php else : ?>
            <p>Nenhum fornecedor encontrado</p>
        <?php endif; ?>

        <a href="principal.php">Voltar</a>
        <address>
          <br><br><br><br>
            Raquel Fernandes / Estudante / raquel_f_brito@estudante.sesisenai.org.br
        </address>

</body>
</html>





<!-- <?php 
/*session_start();
require_once __DIR__ . '/../php/conexao.php';*/

/*if($_SESSION['id_funcao'] != 1 && $_SESSION['id_funcao'] != 2) {
    echo "<script>alert('Acesso Negado!');window.location.href='../principal.php';</script>";
}*/

/*$fornecedores = [];

$sql = "SELECT id_fornecedor, razao_social, responsavel, email_fornecedor, telefone_fornecedor, cep_fornecedor FROM fornecedores";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);*/

?> -->