<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $conf  = $_POST['conf_senha'] ?? '';

    // --- Validações ---
    $erros = [];

    if (empty($nome)) {
        $erros[] = 'O nome é obrigatório.';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'Informe um e-mail válido.';
    }

    if (strlen($senha) < 6) {
        $erros[] = 'A senha deve ter pelo menos 6 caracteres.';
    }

    if ($senha !== $conf) {
        $erros[] = 'As senhas não coincidem.';
    }

    // Verifica se o e-mail já está cadastrado
    foreach ($_SESSION['usuarios'] as $u) {
        if ($u['email'] === $email) {
            $erros[] = 'Este e-mail já está cadastrado.';
            break;
        }
    }

    // Se houver erros, volta para o cadastro com as mensagens
    if (!empty($erros)) {
        $_SESSION['erros_cadastro'] = $erros;
        header('Location: cadastro.php');
        exit;
    }

    // --- Salva o usuário na sessão ---
    $novoUsuario = [
        'nome'  => htmlspecialchars($nome),
        'email' => htmlspecialchars($email),
        'senha' => password_hash($senha, PASSWORD_DEFAULT)
    ];

    $_SESSION['usuarios'][] = $novoUsuario;

    $_SESSION['sucesso_cadastro'] = 'Cadastro realizado com sucesso! Faça login.';
    header('Location: index.php');
    exit;
}
?>