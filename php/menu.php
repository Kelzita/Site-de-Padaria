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
        "Histórico de Vendas" => ["../php/HistoricoVendas.php" => "Histórico de Vendas"],
        "Gestão de Produtos e Estoque" => [
            "../html_cadastros/cadastrar_produto.php" => "Cadastrar Produto",
            "../html_listas/estoque_atual.php" => "Estoque Atual",
            "../php/alterar_produtos.php" => "Alterar Produtos",
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

<!-- =================== ESTILOS DO MENU =================== -->

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
    font-family: 'Poppins', sans-serif;
    background-color: #f4ece6;
    color: #3d2b1f;
}

/* MENU PRINCIPAL */
nav {
    background: linear-gradient(90deg, #8b5e3c, #6b4226);
    padding: 0 20px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    width: 100%;
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
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 15px 20px;
    color: #f4ede6;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s, color 0.3s;
    border-radius: 5px;
}

nav ul.menu > li > a:hover {
    background: linear-gradient(90deg, #5c3d25, #3e2617);
    color: #fff;
}

/* FOTO DE PERFIL AO LADO DA OPÇÃO PERFIL */
.perfil-menu-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #f4ede6;
}

/* SUBMENU */
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0px;
    list-style: none;
    background: linear-gradient(180deg, #6b4226, #5c3d25);
    padding: 10px 0;
    min-width: 180px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s ease-in-out;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
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
    color: #f4ede6;
    text-decoration: none;
    transition: background 0.3s;
    border-radius: 5px;
}

.dropdown-menu li a:hover {
    background: linear-gradient(90deg, #8b5e3c, #6b4226);
    color: #fff;
}



</style>

<!-- =================== MENU HTML =================== -->
<nav>
    <ul class="menu">
        <!-- LOGO DO SITE -->
        <li class="logo">
            <a href="../index.php">
                <img src="../img/logo.png" alt="Logo do Site" class="menu-logo">
            </a>
        </li>

        <?php foreach($opcoes_menu as $menu => $telas): ?>
            <li class="dropdown">
                <a href="#">
                    <!-- Exibe a foto apenas na opção Perfil -->
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
