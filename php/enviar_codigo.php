<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

require_once "conexao.php";

$email = $_POST['email'] ?? '';

if ($email) {
    $stmt = $pdo->prepare("SELECT id_funcionario FROM funcionarios WHERE email_funcionario = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $senhaTemp = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
        $hashSenha = password_hash($senhaTemp, PASSWORD_DEFAULT);

        $update = $pdo->prepare("UPDATE funcionarios SET senha = ?, senha_temporaria = 1 WHERE id_funcionario = ?");
        $update->execute([$hashSenha, $user['id_funcionario']]);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'jamillyrodriguesfroes@gmail.com';
            $mail->Password   = 'njguoouwigyhrbtv';          
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('jamillyrodriguesfroes@gmail.com', 'Pão Genial');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Sua senha temporária';
            $mail->Body    = "Sua senha temporária é: <b>$senhaTemp</b>";

            $mail->send();

            echo "<script>alert('Senha temporária enviada!'); window.location='../index.php';</script>";
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('E-mail não encontrado!'); window.location='../redefinirsenha.html';</script>";
    }
} else {
    echo "<script>alert('Preencha o e-mail!'); window.location='../redefinirsenha.html';</script>";
}
?>
