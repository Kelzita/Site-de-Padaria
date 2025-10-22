<?php
//======Variáveis do Banco======
$host = "db"; // Conecta-se ao servidor local ( Ou seja na máquina utilizada )
$user = "root"; // Usuário, geralmente root
$pass = "root"; // Senha, geralmente vazia
$banco = "padaria_pao_genial"; // Banco de dados que será utilizado

//======Criando a conexão com o banco em PDO======
try {
$dsn = "mysql:host=$host;dbname=$banco;charset=utf8";
$pdo = new PDO($dsn, $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Se o banco for conectado com sucesso, ele irá exibir uma mensagem, dizendo que o banco está executando corretamente

// Configura o PDO para lançar exceções em caso de erros.
// PDO::ATTR_ERRMODE: Define o modo de relatório de erros.
// PDO::ERRMODE_EXCEPTION: Se ocorrer um erro na comunicação com o banco (ex: consulta SQL errada),
// o PDO lançará uma exceção (um tipo especial de erro que pode ser "capturado" pelo bloco catch).
// Isso é bom para depuração e para tratar erros de forma mais robusta.]




} catch (PDOException $e ){
    // Se ocorrer qualquer erro (uma PDOException) durante a tentativa de conexão no bloco 'try',
    // o código dentro deste bloco 'catch' será executado.




    // $e é um objeto que contém informações sobre o erro que ocorreu.
    // $e->getMessage() retorna uma mensagem descrevendo o erro.
    die("<script>alert('Erro ao conectar-se ao banco');</script>" . $e->getMessage()); // Interrompe a execução e exibe uma mensagem de erro!



    

    
}
?>
