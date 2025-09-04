<?php
session_start();
require_once 'conexao.php';

// ====== VERIFICA LOGIN ======
if (!isset($_SESSION['id_funcionario'])) {
    header("Location: ../index.php");
    exit();
}

$id_funcionario = $_SESSION['id_funcionario'];

// ====== BUSCA DADOS ATUAIS ======
$sql = "SELECT nome_funcionario, email_funcionario, imagem_funcionario 
        FROM funcionarios 
        WHERE id_funcionario = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id_funcionario]);
$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    die("Funcionário não encontrado.");
}

// ====== GARANTE QUE A SESSÃO TENHA A IMAGEM CORRETA ======
$_SESSION['nome_funcionario'] = $funcionario['nome_funcionario'];
$_SESSION['imagem_funcionario'] = (!empty($funcionario['imagem_funcionario']) && file_exists($funcionario['imagem_funcionario']))
    ? $funcionario['imagem_funcionario']
    : '../img/default_avatar.png';

$imagem_atual = $_SESSION['imagem_funcionario'];
$mensagem = '';

// ====== PROCESSA ALTERAÇÕES ======
if (isset($_POST['alterar'])) {

    // ===== ALTERAR NOME =====
    $novo_nome = trim($_POST['nome_funcionario'] ?? '');
    if (!empty($novo_nome) && $novo_nome !== $funcionario['nome_funcionario']) {
        $sql = "UPDATE funcionarios SET nome_funcionario = :nome WHERE id_funcionario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $novo_nome,
            ':id' => $id_funcionario
        ]);
        $_SESSION['nome_funcionario'] = $novo_nome;
    }

    // ===== ALTERAR SENHA =====
    $nova_senha = trim($_POST['senha_funcionario'] ?? '');
    if (!empty($nova_senha)) {
        $hash_senha = password_hash($nova_senha, PASSWORD_DEFAULT);
        $sql = "UPDATE funcionarios SET senha = :senha WHERE id_funcionario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':senha' => $hash_senha,
            ':id' => $id_funcionario
        ]);
    }

    // ===== ALTERAR IMAGEM =====
    if (!empty($_FILES['imagem_funcionario']['tmp_name'])) {
        if (!is_dir('../uploads')) {
            mkdir('../uploads', 0755, true);
        }

        $arquivo_tmp = $_FILES['imagem_funcionario']['tmp_name'];
        $nome_arquivo = '../uploads/' . uniqid() . '_' . basename($_FILES['imagem_funcionario']['name']);

        if (move_uploaded_file($arquivo_tmp, $nome_arquivo)) {
            $sql = "UPDATE funcionarios SET imagem_funcionario = :imagem WHERE id_funcionario = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':imagem' => $nome_arquivo,
                ':id' => $id_funcionario
            ]);

            $_SESSION['imagem_funcionario'] = $nome_arquivo;
        } else {
            $mensagem = "<p style='color:red;'>Erro ao enviar a foto.</p>";
        }
    }

    if (empty($mensagem)) {
        $mensagem = "<p style='color:green;'>Perfil atualizado com sucesso!</p>";
    }

    // Atualiza dados do funcionário após alterações
    $stmt = $pdo->prepare("SELECT nome_funcionario, imagem_funcionario FROM funcionarios WHERE id_funcionario = :id");
    $stmt->execute([':id' => $id_funcionario]);
    $funcionario_atualizado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($funcionario_atualizado) {
        $_SESSION['nome_funcionario'] = $funcionario_atualizado['nome_funcionario'];
        $_SESSION['imagem_funcionario'] = (!empty($funcionario_atualizado['imagem_funcionario']) && file_exists($funcionario_atualizado['imagem_funcionario']))
            ? $funcionario_atualizado['imagem_funcionario']
            : '../img/default_avatar.png';
        $funcionario = $funcionario_atualizado;
        $imagem_atual = $_SESSION['imagem_funcionario'];
    }

    header("Location: ../inicio/home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Funcionário</title>
    <link rel="stylesheet" href="../css/styleperfilfunc.css">
    <!-- CDN do Remix Icon para o ícone do olho -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        /* Estilização do campo de senha com ícone */
        .campo-senha {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .campo-senha input {
            width: 100%;
            padding-right: 40px; /* Espaço para o ícone */
            box-sizing: border-box;
        }

        .toggle-olho {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: #777;
            transition: 0.3s;
        }

        .toggle-olho:hover {
            color: #333;
            transform: translateY(-50%) scale(1.15);
        }
    </style>
</head>
<body>
<header>
    <img src="../img/logo_pg.png" alt="Logo da Padaria">
</header>

<div class="retangulo">
    <a href="../inicio/home.php" class="voltar"> 
        <img class="seta" src="../img/btn_voltar.png" title="seta">
    </a>
    <h1>Meu Perfil</h1>

    <?= $mensagem ?>

    <form id="form-perfil" action="" method="post" enctype="multipart/form-data">
        <!-- Upload de Imagem -->
        <div class="imagem-upload-wrapper">
            <label for="imagem_funcionario" class="custom-file-label" id="preview-container" title="Clique para mudar a foto">
                <img src="<?= htmlspecialchars($imagem_atual) ?>" alt="Foto de Perfil" id="preview-img" class="img-preview"/>
                <span class="trocar-texto">Trocar Imagem</span>
            </label>
            <input type="file" name="imagem_funcionario" id="imagem_funcionario" accept="image/*" style="display:none;" />
        </div>

        <!-- Nome -->
        <label for="nome_funcionario">Nome:</label>
        <input type="text" name="nome_funcionario" value="<?= htmlspecialchars($funcionario['nome_funcionario']) ?>" required>

        <!-- Senha -->
        <label for="senha_funcionario">Nova Senha:</label>
        <div class="campo-senha">
            <input type="password" name="senha_funcionario" id="senha_funcionario" placeholder="Digite a nova senha" maxlength="20">
            <i class="ri-eye-off-line toggle-olho" onclick="toggleSenha()"></i>
        </div>
        <small id="erro-senha" style="color:red; display:none;"></small>


        <button type="submit" name="alterar">Alterar</button>
    </form>
</div>

<script>
    const form = document.getElementById('form-perfil');
const erroSenha = document.getElementById('erro-senha');

form.addEventListener('submit', function(event) {
    const senha = document.getElementById('senha_funcionario').value.trim();

    // Se o campo estiver vazio, permite (não altera a senha)
    if (senha !== "") {
        const regex = /^(?=.*[A-Z])(?=.*\d).{6,20}$/;
        // Explicação:
        // (?=.*[A-Z]) -> pelo menos uma letra maiúscula
        // (?=.*\d)    -> pelo menos um número
        // .{6,20}     -> mínimo 6 e máximo 20 caracteres

        if (!regex.test(senha)) {
            erroSenha.style.display = "block";
            erroSenha.textContent = "Senha deve ter 6-20 caracteres, pelo menos uma letra maiúscula e um número.";
            event.preventDefault(); // impede envio
            return false;
        } else {
            erroSenha.style.display = "none";
        }
    }
});

// Função para mostrar/ocultar a senha
function toggleSenha() {
    const input = document.getElementById('senha_funcionario');
    const icone = document.querySelector('.toggle-olho');

    if (input.type === "password") {
        input.type = "text";
        icone.classList.remove("ri-eye-off-line");
        icone.classList.add("ri-eye-line");
    } else {
        input.type = "password";
        icone.classList.remove("ri-eye-line");
        icone.classList.add("ri-eye-off-line");
    }
}

</script>

</body>
</html>
