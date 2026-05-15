<?php
require_once 'init.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Gerenciador de Tarefas</title>
</head>
<body>
    <h1>Cadastro de Usuário</h1>
    <form action="processar_cadastro.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br>

        <label for="conf_senha">Confirmar Senha:</label>
        <input type="password" name="conf_senha" id="conf_senha" required><br>

        <button type="submit">Cadastrar</button>
    </form>
    <p>Já tem conta? <a href="index.php">Faça login</a></p>
</body>
</html>