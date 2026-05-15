<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $novoUsuario = [
        'nome' => $nome,
        'email' => $email,
        'senha' => $senha
    ];

    $_SESSION['usuarios'][] = $novoUsuario;

    header('Location: login.php');
    exit;
}
?>