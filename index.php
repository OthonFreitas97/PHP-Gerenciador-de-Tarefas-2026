<?php
require_once 'init.php';

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
    <link rel="stylesheet" href="./assets/style.css">
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
                <?php if (!empty($_SESSION['erro_login'])): ?>
                    <div class="alert alert-error">
                        <?= htmlspecialchars($_SESSION['erro_login']) ?>
                        <?php unset($_SESSION['erro_login']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['sucesso_cadastro'])): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($_SESSION['sucesso_cadastro']) ?>
                        <?php unset($_SESSION['sucesso_cadastro']); ?>
                    </div>
                <?php endif; ?>

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