<?php 
session_start();
echo "<script>confirm('Deseja mesmo encerrar a sessão?'); alert('Encerrando a sessão...'); window.location.href='../index.php';</script>";
session_destroy();
exit();
?>