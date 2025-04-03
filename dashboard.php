<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: Entrar.html");
    exit();
}
echo "Bem-vindo, " . $_SESSION['email'];
?>
<a href="logout.php">Sair</a>
