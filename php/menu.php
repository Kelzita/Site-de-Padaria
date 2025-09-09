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

// ========== PERMISSÕES ==========
$permissoes = [
    1 => [ // Administrador
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
    2 => [ // Estoque
        "Gestão de Produtos e Estoque" => [
            "../html_cadastros/cadastrar_produto.php" => "Cadastrar Produto",
            "../html_listas/estoque_atual.php" => "Estoque Atual",
            "../html_listas/lista_de_produto.php" => "Gerenciar Produtos"
        ],
        "Perfil" => [
            "../inicio/perfil.php" => "Meu Perfil",
            "../inicio/suporte.php" => "Suporte",
            "../php/logout.php" => "Sair"
        ]
    ],
    3 => [ // Garçom
        "Comanda" => ["../php/comanda.php" => "Abrir Comanda"],
        "Perfil" => [
            "../inicio/perfil.php" => "Meu Perfil",
            "../inicio/suporte.php" => "Suporte",
            "../php/logout.php" => "Sair"
        ]
    ],
    4 => [ // Caixa
        "Caixa" => ["../php/caixa.php" => "Acessar Caixa"],
        "Perfil" => [
            "../inicio/perfil.php" => "Meu Perfil",
            "../inicio/suporte.php" => "Suporte",
            "../php/logout.php" => "Sair"
        ]
    ]
];

// =======================
// 1. Menu sempre do ADM
// 2. Mas checa se função atual tem acesso
// =======================
$menu_admin = $permissoes[1];
$menu_user  = $permissoes[$id_funcao] ?? [];
?>
<link rel="stylesheet" href="../css/menu.css"/>
<link rel="stylesheet" href="../css/styles.css"/>
<link rel="stylesheet" href="../css/stylehome.css"/>

<nav>
    <ul class="menu">
        <!-- LOGO -->
        <li class="logo">
            <a href="../inicio/home.php">
                <img src="../img/logo.png" alt="Logo do Site" class="menu-logo">
            </a>
        </li>

        <?php foreach($menu_admin as $menu => $telas): ?>
            <?php
            // Verifica se o usuário tem pelo menos 1 permissão nesse grupo
            $temAlgumaPermissao = false;
            foreach ($telas as $link => $nomeTela) {
                foreach ($menu_user as $telas_user) {
                    if (array_key_exists($link, $telas_user)) {
                        $temAlgumaPermissao = true;
                        break 2; // sai dos 2 loops
                    }
                }
            }
            ?>
            <li class="dropdown <?= $temAlgumaPermissao ? '' : 'no-access' ?>">
                <a href="#">
                    <?php if ($menu === "Perfil"): ?>
                        <img src="<?= htmlspecialchars($imagem_funcionario) ?>" alt="Foto de Perfil" class="perfil-menu-img">
                    <?php endif; ?>
                    <?= htmlspecialchars($menu) ?>
                </a>

                <?php if ($temAlgumaPermissao): ?>
                    <ul class="dropdown-menu">
                        <?php foreach($telas as $link => $nomeTela): ?>
                            <?php
                            $temPermissao = false;
                            foreach ($menu_user as $telas_user) {
                                if (array_key_exists($link, $telas_user)) {
                                    $temPermissao = true;
                                    break;
                                }
                            }
                            ?>
                            <li>
                                <?php if ($temPermissao): ?>
                                    <a href="<?= htmlspecialchars($link) ?>"><?= htmlspecialchars($nomeTela) ?></a>
                                <?php else: ?>
                                    <span class="disabled"><?= htmlspecialchars($nomeTela) ?></span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<style>
/* Itens bloqueados */
.disabled {
    color: gray;
    cursor: not-allowed;
    display: block;
    padding: 8px 12px;
}

/* Menus sem nenhuma permissão */
.no-access > a {
    color: gray;
    cursor: not-allowed;
    text-decoration: line-through;
}

/* Desabilita totalmente o dropdown */
.no-access > ul {
    display: none !important;
}
</style>
