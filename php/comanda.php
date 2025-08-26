<?php
session_start();
require_once 'conexao.php';

if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    //VERIFICA SE A BUSCA É UM numero OU UM nome
    if(is_numeric($busca)){
        $sql="SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca',$busca, PDO::PARAM_INT);
    }else{
        $sql="SELECT * FROM produto WHERE nome LIKE :busca_nome ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome',"%$busca%", PDO::PARAM_STR);
    }
}else{
    //BUSCA TODOS OS PRODUTOS CADASTRADOS ORDENADOS POR ID DE PRODUTO
        $sql="SELECT * FROM produto ORDER BY id_produto ASC";
        $stmt = $pdo->prepare($sql);
}
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
        <tr>
            <td><?=htmlspecialchars($produto['id_produto'])?></td>
            <td><?=htmlspecialchars($produto['id_fornecedor'])?></td>
            <td><?=htmlspecialchars($produto['categoria'])?></td>
            <td><?=htmlspecialchars($produto['nome_prod'])?></td>
            <td><?=htmlspecialchars($produto['descricao'])?></td>
            <td><?=htmlspecialchars($produto['qtde'])?></td>
            <td><?=htmlspecialchars($produto['valor_unit'])?></td>
            <tr>
                  <th>ID Produto</th>
                  <th>ID Fornecedor</th>
                  <th>Categoria</th>
                  <th>Nome</th>
                  <th>Descrição</th>
                  <th>Quantidade</th>
                  <th>Validade</th>
                  <th>Preço Unitário</th>
                  <th>Ações</th>
                </tr>
            <td>
                <a href="excluir_produto.php?id=<?=htmlspecialchars($produto['id_produto'])?>">Adicionar</a>              
            </td>
        </tr>
        <?php endforeach;?>
    </table>
<?php else:?>

    <p>Nenhum produto encontrado.</p>

<?php endif;?>
