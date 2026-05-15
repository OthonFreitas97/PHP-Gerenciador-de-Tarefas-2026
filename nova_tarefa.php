<?php
require_once 'init.php';

verificarAcesso();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Tarefa - Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
<header>
    <nav>
        <?php require_once("./menu.php"); ?>
    </nav>
</header>

<main>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Criar Nova Tarefa</h1>
            <p>Preencha os dados abaixo para criar uma nova tarefa</p>
        </div>

        <form action="processar_tarefa.php" method="post">
            <?php if (!empty($_SESSION['erros_tarefa'])): ?>
                <div class="alert alert-error">
                    <ul>
                    <?php 
                        foreach ($_SESSION['erros_tarefa'] as $erro) {
                            echo '<li>' . htmlspecialchars($erro) . '</li>';
                        }
                        unset($_SESSION['erros_tarefa']);
                    ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="titulo">Título *</label>
                <input type="text" name="titulo" id="titulo" placeholder="Digite o título da tarefa" value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição *</label>
                <textarea name="descricao" id="descricao" placeholder="Digite a descrição da tarefa" rows="4" required><?= htmlspecialchars($_POST['descricao'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label for="responsavel">Responsável *</label>
                <input type="text" name="responsavel" id="responsavel" placeholder="Nome do responsável" value="<?= htmlspecialchars($_POST['responsavel'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="data_vencimento">Data de Vencimento *</label>
                <input type="datetime-local" name="data_vencimento" id="data_vencimento" value="<?= htmlspecialchars($_POST['data_vencimento'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="pendente" <?= (($_POST['status'] ?? 'pendente') === 'pendente') ? 'selected' : '' ?>>Pendente</option>
                    <option value="andamento" <?= (($_POST['status'] ?? '') === 'andamento') ? 'selected' : '' ?>>Em Andamento</option>
                    <option value="concluida" <?= (($_POST['status'] ?? '') === 'concluida') ? 'selected' : '' ?>>Concluída</option>
                </select>
            </div>

            <button type="submit" class="btn-primary">Criar Tarefa</button>
            <a href="painel.php" class="btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
</main>

<footer>
    <small>Copyright &copy; - <?= date("Y") ?> - Gerenciador de Tarefas</small>
</footer>

</body>
</html>