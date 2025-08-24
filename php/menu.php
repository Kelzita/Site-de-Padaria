<?php
// Inicia sessão se ainda não estiver ativa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexao.php';

// Verifica se usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

//========== Obtem o nome do perfil e do usuário logado ==========
$id_funcao = $_SESSION['funcao'] ?? null;

$sqlFuncao = "SELECT nome_funcao FROM funcao WHERE id_funcao = :id_funcao";
$stmtFuncao = $pdo->prepare($sqlFuncao);
$stmtFuncao->bindParam(':id_funcao', $id_funcao);
$stmtFuncao->execute();

$funcao = $stmtFuncao->fetch(PDO::FETCH_ASSOC);
if (!$funcao) {
    die("Função do usuário não encontrada!");
}

$nome_funcao = $funcao['nome_funcao'];

// Permissões por perfil
$permissoes = [
    1 => [
        "Historico de Vendas" => ["../html_relatorios/historico_de_vendas.php"],
        "Gestão de Produtos e Estoque" => [
            "html_cadastros/cadastrar_produto.php",
            "html_listas/estoque_atual.php",
            "html_gerenciamento/gerenciar_produtos.php"
        ],
        "Gestão de Funcionarios" => [
            "html_cadastros/cadastrar_funcionario.php",
            "html_listas/Lista_de_funcionarios.php"
        ],
        "Gestão de Fornecedores" => [
            "html_cadastros/cadastrar_fornecedor.php",
            "html_listas/lista_de_fornecedores.php"
        ],
        "Relatórios" => ["../html_relatorios/relatorios.php"],
        "Caixa" => ["../caixanovo/caixa.html"],
        "Comanda" => ["../html/comanda.php"]
    ],
    2 => [
        "Historico de Vendas" => ["../html_relatorios/historico_de_vendas.php"],
        "Gestão de Produtos e Estoque" => [
            "../html_cadastros/cadastrar_produto.php",
            "../html_listas/estoque_atual.php",
            "../html_gerenciamento/gerenciar_produtos.php"
        ],
        "Relatórios" => ["../html_relatorios/relatorios.php"]
    ],
    3 => [
        "Historico de Vendas" => ["../html_relatorios/historico_de_vendas.php"],
        "Comanda" => ["../html/comanda.php"]
    ],
    4 => [
        "Historico de Vendas" => ["../html_relatorios/historico_de_vendas.php"],
        "Caixa" => ["../caixanovo/caixa.html"]
    ]
];

// Verifica se existem permissões para o perfil
if (!isset($permissoes[$id_funcao])) {
    die("Permissões não definidas para esta função.");
}

$opcoes_menu = $permissoes[$id_funcao];
?>

<style>
/* =================== RESET =================== */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f4f9;
    color: #333;
}

/* =================== MENU =================== */
nav {
    background-color: #2c3e50;
    padding: 0 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

nav ul.menu {
    list-style: none;
    display: flex;
    justify-content: flex-start;
}

nav ul.menu > li {
    position: relative;
}

nav ul.menu > li > a {
    display: block;
    padding: 15px 20px;
    color: #ecf0f1;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s, color 0.3s;
}

nav ul.menu > li > a:hover {
    background-color: #34495e;
    color: #fff;
    border-radius: 5px;
}

/* =================== DROPDOWN =================== */
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    list-style: none;
    background-color: #34495e;
    padding: 10px 0;
    min-width: 180px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s ease-in-out;
    border-radius: 5px;
    z-index: 10;
}

.dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-menu li a {
    display: block;
    padding: 10px 20px;
    color: #ecf0f1;
    text-decoration: none;
    transition: background 0.3s;
}

.dropdown-menu li a:hover {
    background-color: #1abc9c;
    color: #fff;
    border-radius: 5px;
}
</style>

<nav>
    <ul class="menu">
        <?php foreach($opcoes_menu as $menu => $telas) : ?>
            <li class="dropdown">
                <a href="#"><?= htmlspecialchars($menu) ?></a>
                <ul class="dropdown-menu">
                    <?php foreach($telas as $tela) : ?>
                        <li>
                            <a href="<?= htmlspecialchars($tela) ?>">
                                <?= ucfirst(str_replace("_", " ", basename($tela, ".php"))) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
       
    </ul>
</nav>
