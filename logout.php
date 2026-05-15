<?php
require_once 'init.php';

if (isset($_SESSION['usuario_logado'])) {
    unset($_SESSION['usuario_logado']);
}

$_SESSION['sucesso_login'] = 'Você foi desconectado com sucesso.';

// Redireciona para login
header('Location: index.php');
exit;
?>