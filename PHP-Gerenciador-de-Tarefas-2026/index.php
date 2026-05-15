<?php
require_once 'init.php';

// Se já estiver logado, vai direto pro painel
if (isset($_SESSION['usuario_logado'])) {
    header('Location: painel.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <span class="icon">✔</span>
                <h1>Gerenciador de Tarefas</h1>
                <p>Faça login para continuar</p>
            </div>

            <form action="processar_login.php" method="post">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="seu@email.com" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-primary">Entrar</button>
            </form>

            <p class="link-bottom">Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
        </div>
    </div>
</body>
</html>