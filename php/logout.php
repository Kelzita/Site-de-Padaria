<?php
session_start();

// Se o usuário já confir, destrói a sessão
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>

<script>

if (confirm('Deseja mesmo encerrar a sessão?')) {
    window.location.href = '?logout=true';
} else {
    window.history.back();
}
</script>
