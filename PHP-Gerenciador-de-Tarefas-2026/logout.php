<?php

session_start();

if (isset($_SESSION['usuario_logado'])) {
    unset($_SESSION['usuario_logado']);
}

header('Location: index.php');
exit;
?>