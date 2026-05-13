<?php
// É necessário iniciar a sessão para poder manipulá-la
session_start();

// Remove apenas a chave que identifica que o usuário está logado (Requisito 6)
if (isset($_SESSION['usuario_logado'])) {
    unset($_SESSION['usuario_logado']);
}

// Redireciona o usuário para a tela de login imediatamente
header('Location: index.php');
exit;
?>