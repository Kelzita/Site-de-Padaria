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
$imagem_funcionario = $_SESSION['imagem_funcionario'] ?? null;

if ($imagem_funcionario) {
    // Se for binário do banco, transforma em base64
    if (!str_starts_with($imagem_funcionario, 'data:image')) {
        $imagem_funcionario = 'data:image/jpeg;base64,' . base64_encode($imagem_funcionario);
    }
} else {
    $imagem_funcionario = '../img/avatars/default_avatar.png';
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
        "Histórico de Vendas" => ["../php/historicodevendas.php" => "Histórico de Vendas"],
        "Gestão de Produtos e Estoque" => [
            "../html_cadastros/cadastrar_produto.php" => "Cadastrar Produto",
            "../html_listas/estoque_atual.php" => "Estoque Atual",
            "../html_listas/lista_de_produto.php" => "Lista de Produtos",
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
        "Perfil" => [
            "../inicio/perfil.php" => "Meu Perfil",
            "../inicio/suporte.php" => "Suporte",
            "../php/logout.php" => "Sair"
        ]
    ],
    2 => [
        "Gestão de Produtos e Estoque" => [
            "../html_cadastros/cadastrar_produto.php" => "Cadastrar Produto",
            "../html_listas/estoque_atual.php" => "Estoque Atual",
            "../html_listas/lista_de_produto.php" => "Gerenciar Produtos"
        ],
        "Relatórios" => ["../php/relatorio_vendas.php" => "Relatório de Vendas"],
        "Perfil" => [
            "../inicio/perfil.php" => "Meu Perfil",
            "../inicio/suporte.php" => "Suporte",
            "../php/logout.php" => "Sair"
        ]
    ],
    3 => [
        "Comanda" => ["../php/comanda.php" => "Abrir Comanda"],
        "Perfil" => [
            "../inicio/perfil.php" => "Meu Perfil",
            "../inicio/suporte.php" => "Suporte",
            "../php/logout.php" => "Sair"
        ]
    ],
    4 => [
        "Caixa" => ["../php/caixa.php" => "Acessar Caixa"],
        "Perfil" => [
            "../inicio/perfil.php" => "Meu Perfil",
            "../inicio/suporte.php" => "Suporte",
            "../php/logout.php" => "Sair"
        ]
    ]
];


// Verifica se existem permissões para o perfil
if (!isset($permissoes[$id_funcao])) {
    die("Permissões não definidas para esta função.");
}

$opcoes_menu = $permissoes[$id_funcao];
?>
<link rel="stylesheet" href="../css/menu.css"/>

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
