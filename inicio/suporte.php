<?php 
require_once '../php/menu.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_funcionario'])) {
    header("Location: ../index.php");
    exit();
}

// Conexão com o banco
require_once '../php/conexao.php';

// Busca o nome da função do funcionário logado
$id_funcao = $_SESSION['id_funcao'] ?? null;

$sql = "SELECT nome_funcao FROM funcao WHERE id_funcao = :id_funcao";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_funcao', $id_funcao, PDO::PARAM_INT);
$stmt->execute();
$funcao = $stmt->fetch(PDO::FETCH_ASSOC);

$nome_funcao = $funcao['nome_funcao'] ?? 'Função não encontrada';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Suporte MEJR</title>
  <link rel="stylesheet" href="../css/stylehome.css">
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="icon" href="img/logo_title.png">
  <style>

    .suporte-container {
        margin-top: 20px;
        margin-BOTTOM: 20px;
        background-color: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        text-align: center;
        max-width: 500px;
        width: 100%;
    }

    .logo {
        height: 200px;
        margin-bottom: -40px;
    }

    h1 {
        color: #333;
        margin-bottom: 10px;
    }

    p {
        color: #555;
        margin-bottom: 30px;
    }

    .contato {
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
    }

    .contato a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
        gap: 15px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .contato a:hover {
        color: #007bff;
    }

    .contato img {
        width: 40px;
        height: 40px;
    }
  </style>
</head>
<body>
  <div class="suporte-container">
      <!-- Logo da MEJR -->
      <img src="../img/MEJR.png" alt="Logo MEJR" class="logo">

      <h1>Suporte MEJR</h1>
      <p>Entre em contato conosco pelos canais abaixo:</p>

      <div class="contato">
    <a href="https://wa.me/5547997737413" target="_blank" class="contato-link">
        <img src="../img/whatsapp.png" alt="WhatsApp" class="contato-icone">
        <span>WhatsApp: (47) 99773-7413</span>
    </a>    
    <span>Ou</span>

    <!-- QR Code funcional -->
    <a href="https://wa.me/5547997737413" target="_blank" class="qr-code">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://wa.me/5547997737413" alt="QR Code WhatsApp">
      
        <span>Escaneie para abrir no WhatsApp</span>
    </a>
    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=raquel_f_brito@estudante.sesisenai.org.br&su=SuporteMEJR&body=Olá,%20equipe%20do%20SuporteMEJR," target="_blank" class="contato-link">
        <img src="../img/email.png" alt="Email" class="contato-icone">
        <div class="contato-info">
            <span class="contato-titulo">Email</span>
            <span class="contato-texto">Clique para abrir no Gmail</span>
        </div>
    </a>


    </div>
  </div>
</body>
</html>
