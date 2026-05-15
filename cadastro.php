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
    <title>Cadastro - Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <span class="icon">✔</span>
                <h1>Cadastro de Usuário</h1>
                <p>Preencha os dados abaixo para criar sua conta</p>
            </div>

            <form action="processar_cadastro.php" method="post">
                <?php if (!empty($_SESSION['erros_cadastro'])): ?>
                    <div class="alert alert-error">
                        <ul>
                        <?php 
                            foreach ($_SESSION['erros_cadastro'] as $erro) {
                                echo '<li>' . htmlspecialchars($erro) . '</li>';
                            }
                            unset($_SESSION['erros_cadastro']);
                        ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" placeholder="Seu nome completo" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="seu@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label for="conf_senha">Confirmar Senha</label>
                    <input type="password" name="conf_senha" id="conf_senha" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-primary">Cadastrar</button>
            </form>

            <p class="link-bottom">Já tem conta? <a href="index.php">Faça login</a></p>
        </div>
    </div>
</body>
</html>