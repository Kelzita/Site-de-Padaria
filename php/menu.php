<?php
// Inicia sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexao.php';

// ====== VERIFICA LOGIN ======
if (!isset($_SESSION['id_funcionario'])) {
    header("Location: ../index.php");
    exit();
}

// ====== DADOS DO FUNCIONÁRIO ======
$id_funcao = $_SESSION['id_funcao'] ?? null;
$imagem_funcionario = $_SESSION['imagem_funcionario'] ?? '../img/default_avatar.png';

// Caso a imagem salva não exista fisicamente, usa a padrão
if (!file_exists($imagem_funcionario)) {
    $imagem_funcionario = '../img/default_avatar.png';
}

// ====== BUSCA O NOME DA FUNÇÃO ======
$sqlFuncao = "SELECT nome_funcao FROM funcao WHERE id_funcao = :id_funcao";
$stmtFuncao = $pdo->prepare($sqlFuncao);
$stmtFuncao->bindParam(':id_funcao', $id_funcao, PDO::PARAM_INT);
$stmtFuncao->execute();

$funcao = $stmtFuncao->fetch(PDO::FETCH_ASSOC);
if (!$funcao) {
    die("Função do funcionário não encontrada!");
}

$nome_funcao = $funcao['nome_funcao'];

// ========== PERMISSÕES DE MENU ==========
$permissoes = [
    1 => [
        "Histórico de Vendas" => ["../historicodevendas.html" => "Histórico de Vendas"],
        "Gestão de Produtos e Estoque" => [
            "../html_cadastros/cadastrar_produto.php" => "Cadastrar Produto",
            "../html_listas/estoque_atual.php" => "Estoque Atual",
            "../html_listas/lista_de_produto.php" => "Alterar Produtos",
        ],
        "Gestão de Funcionários" => [
            "../html_cadastros/cadastrar_funcionario.php" => "Cadastrar Funcionário",
            "../html_listas/Lista_de_funcionarios.php" => "Lista de Funcionários"
        ],
        "Gestão de Fornecedores" => [
            "../html_cadastros/cadastrar_fornecedor.php" => "Cadastrar Fornecedor",
            "../html_listas/lista_de_fornecedores.php" => "Lista de Fornecedores"
        ],
        "Relatórios" => ["../php/relatorio_vendas.php" => "Relatório de Vendas"],
        "Caixa" => ["../php/caixa.php" => "Acessar Caixa"],
        "Comanda" => ["../php/comanda.php" => "Abrir Comanda"],
        "Perfil" => ["../php/perfil.php" => "Meu Perfil"],
    ],
    2 => [
        "Gestão de Produtos e Estoque" => [
            "../html_cadastros/cadastrar_produto.php" => "Cadastrar Produto",
            "../html_listas/estoque_atual.php" => "Estoque Atual",
            "../html_gerenciamento/gerenciar_produtos.php" => "Gerenciar Produtos"
        ],
        "Relatórios" => ["../php/relatorio_vendas.php" => "Relatório de Vendas"],
        "Perfil" => ["../php/perfil.php" => "Meu Perfil"],
    ],
    3 => [
        "Comanda" => ["../php/comanda.php" => "Abrir Comanda"],
        "Perfil" => ["../php/perfil.php" => "Meu Perfil"],
    ],
    4 => [
        "Caixa" => ["../php/caixa.php" => "Acessar Caixa"],
        "Perfil" => ["../php/perfil.php" => "Meu Perfil"],
    ]
];

// Verifica se existem permissões para o perfil
if (!isset($permissoes[$id_funcao])) {
    die("Permissões não definidas para esta função.");
}

$opcoes_menu = $permissoes[$id_funcao];
?>

<style>
/* RESET */
html, body {
    margin: 0;
    padding: 0;
}
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: sans-serif;
    background-color: #fafafa;
    color: #333;
    font-weight: bold;
}

/* MENU PRINCIPAL */
nav {
    background: #ffffff;
    padding: 0 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    
}

nav ul.menu {
    list-style: none;
    display: flex;
    justify-content: flex-start; /* Alinha itens à esquerda */
    align-items: center;
    width: 100%;
    gap: 20px; /* Espaçamento fixo */
}

nav ul.menu > li.logo {
    margin-right: auto; /* Empurra os outros itens para a direita */
}

nav ul.menu > li.dropdown {
    min-width: 120px; /* Garante largura mínima */
    text-align: center;
    position: relative;
}

nav ul.menu > li > a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 20px;
    color: #555;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s, color 0.3s;
    border-radius: 5px;
}

nav ul.menu > li > a:hover {
    background: #f2f2f2;
    color: #000;
}

/* FOTO DE PERFIL */
.perfil-menu-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ffffff;
}

/* SUBMENU */
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    list-style: none;
    background: #ffffff;
    padding: 10px 0;
    min-width: 180px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s ease-in-out;
    border-radius: 5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
    color: #555;
    text-decoration: none;
    transition: background 0.3s, color 0.3s;
    border-radius: 5px;
}

.dropdown-menu li a:hover {
    background: #f2f2f2;
    color: #000;
}
</style>

<nav>
    <ul class="menu">
        <!-- LOGO -->
        <li class="logo">
            <a href="../inicio/home.php">
                <img src="../img/logo.png" alt="Logo do Site" class="menu-logo">
            </a>
        </li>

        <?php foreach($opcoes_menu as $menu => $telas): ?>
            <li class="dropdown">
                <a href="#">
                    <?php if ($menu === "Perfil"): ?>
                        <img src="<?= htmlspecialchars($imagem_funcionario) ?>" alt="Foto de Perfil" class="perfil-menu-img">
                    <?php endif; ?>
                    <?= htmlspecialchars($menu) ?>
                </a>
                <ul class="dropdown-menu">
                    <?php foreach($telas as $link => $nomeTela): ?>
                        <li>
                            <a href="<?= htmlspecialchars($link) ?>">
                                <?= htmlspecialchars($nomeTela) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
