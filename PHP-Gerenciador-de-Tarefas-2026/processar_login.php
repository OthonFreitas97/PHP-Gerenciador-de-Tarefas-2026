<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        echo "E-mail e senha são obrigatórios.";
        exit;
    }

    $usuarios = $_SESSION['usuarios'];

    if (isset($usuarios[$email]) && $usuarios[$email]['senha'] === $senha) {
        $_SESSION['usuario_logado'] = $usuarios[$email];   
        header('Location: painel.php');
        exit;
    } else {
        echo "E-mail ou senha incorretos.";
    }
} else {
    header('Location: index.php');
    exit;
}
?>