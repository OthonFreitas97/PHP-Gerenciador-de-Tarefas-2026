<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $_SESSION['erro_login'] = 'E-mail e senha são obrigatórios.';
        header('Location: index.php');
        exit;
    }

    $usuario_encontrado = null;
    foreach ($_SESSION['usuarios'] as $u) {
        if ($u['email'] === $email) {
            $usuario_encontrado = $u;
            break;
        }
    }

    if ($usuario_encontrado && password_verify($senha, $usuario_encontrado['senha'])) {
        $_SESSION['usuario_logado'] = $usuario_encontrado;
        header('Location: painel.php');
        exit;
    } else {
        $_SESSION['erro_login'] = 'E-mail ou senha incorretos.';
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>