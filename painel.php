<?php
require_once 'init.php';

verificarAcesso();

$usuario = $_SESSION['usuario_logado']['nome'];
$usuario_id = $_SESSION['usuario_logado']['id'];

$tarefas = [];
foreach ($_SESSION['tarefas'] as $t) {
    if ($t['usuario_id'] == $usuario_id) {
        $tarefas[] = $t;
    }
}

$total      = count($tarefas);
$pendentes  = 0;
$andamento  = 0;
$concluidas = 0;

foreach ($tarefas as $t) {
    if ($t['status'] === 'pendente')   $pendentes++;
    if ($t['status'] === 'andamento')  $andamento++;
    if ($t['status'] === 'concluida')  $concluidas++;
}

$filtro_status      = $_GET['status']      ?? '';
$filtro_responsavel = $_GET['responsavel'] ?? '';

$responsaveis = [];
foreach ($tarefas as $t) {
    if (!empty($t['responsavel']) && !in_array($t['responsavel'], $responsaveis)) {
        $responsaveis[] = $t['responsavel'];
    }
}

$tarefas_filtradas = [];
foreach ($tarefas as $t) {
    if ($filtro_status != '' && $t['status'] != $filtro_status) {
        continue;
    }

    if ($filtro_responsavel != '' && $t['responsavel'] != $filtro_responsavel) {
        continue;
    }

    $tarefas_filtradas[] = $t;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

    <header class="topbar">
        <div class="topbar-left">
            <span class="icon">✔</span>
            <span class="topbar-title">Gerenciador de Tarefas</span>
        </div>
        <div class="topbar-right">
            <span class="topbar-user">Olá, <strong><?= $usuario ?></strong></span>
            <a href="logout.php" class="btn-logout">Sair</a>
        </div>
    </header>

    <main class="painel-container">

        <div class="stats-grid">
            <div class="stat-card stat-total">
                <span class="stat-numero"><?= $total ?></span>
                <span class="stat-label">Total</span>
            </div>
            <div class="stat-card stat-pendente">
                <span class="stat-numero"><?= $pendentes ?></span>
                <span class="stat-label">Pendentes</span>
            </div>
            <div class="stat-card stat-andamento">
                <span class="stat-numero"><?= $andamento ?></span>
                <span class="stat-label">Em Andamento</span>
            </div>
            <div class="stat-card stat-concluida">
                <span class="stat-numero"><?= $concluidas ?></span>
                <span class="stat-label">Concluídas</span>
            </div>
        </div>

        <form method="get" action="painel.php" class="filtros-form">
            <div class="filtros-grid">

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="">Todos</option>
                        <option value="pendente"  <?= $filtro_status === 'pendente'  ? 'selected' : '' ?>>Pendente</option>
                        <option value="andamento" <?= $filtro_status === 'andamento' ? 'selected' : '' ?>>Em Andamento</option>
                        <option value="concluida" <?= $filtro_status === 'concluida' ? 'selected' : '' ?>>Concluída</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="responsavel">Responsável</label>
                    <select name="responsavel" id="responsavel">
                        <option value="">Todos</option>
                        <?php foreach ($responsaveis as $r): ?>
                            <option value="<?= $r ?>" <?= $filtro_responsavel === $r ? 'selected' : '' ?>>
                                <?= $r ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="data">Data Limite</label>
                    <input type="date" name="data" id="data" value="<?= $filtro_data ?>">
                </div>

                <div class="filtros-acoes">
                    <button type="submit" class="btn-primary">Filtrar</button>
                    <a href="painel.php" class="btn-limpar">Limpar</a>
                </div>

            </div>
        </form>

        <div class="painel-toolbar">
            <h2 class="painel-titulo">
                Minhas Tarefas
                <?php if ($filtro_status || $filtro_responsavel || $filtro_data): ?>
                    <span class="filtro-ativo">filtro ativo</span>
                <?php endif; ?>
            </h2>
            <a href="nova_tarefa.php" class="btn-primary">+ Nova Tarefa</a>
        </div>

        <?php if (empty($tarefas_filtradas)): ?>
            <div class="empty-state">
                <?php if ($filtro_status || $filtro_responsavel || $filtro_data): ?>
                    <p>Nenhuma tarefa encontrada com esses filtros.</p>
                    <a href="painel.php" class="btn-primary">Ver todas</a>
                <?php else: ?>
                    <p>Nenhuma tarefa cadastrada ainda.</p>
                    <a href="nova_tarefa.php" class="btn-primary">Criar primeira tarefa</a>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <div class="tarefas-lista">
                <?php foreach ($tarefas_filtradas as $id => $tarefa): ?>
                    <div class="tarefa-card status-<?= $tarefa['status'] ?>">
                        <div class="tarefa-info">
                            <h3 class="tarefa-titulo"><?= $tarefa['titulo'] ?></h3>
                            <p class="tarefa-desc"><?= $tarefa['descricao'] ?? '' ?></p>
                            <?php if (!empty($tarefa['responsavel'])): ?>
                                <p class="tarefa-responsavel"> <?= $tarefa['responsavel'] ?></p>
                            <?php endif; ?>
                            <?php if (!empty($tarefa['data_limite'])): ?>
                                <p class="tarefa-data"> <?= $tarefa['data_limite'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="tarefa-meta">
                            <span class="badge badge-<?= $tarefa['status'] ?>">
                                <?php
                                    $labels = [
                                        'pendente'  => 'Pendente',
                                        'andamento' => 'Em Andamento',
                                        'concluida' => 'Concluída',
                                    ];
                                    echo $labels[$tarefa['status']] ?? $tarefa['status'];
                                ?>
                            </span>
                            <a href="detalhes_tarefa.php?id=<?= $id ?>" class="btn-detalhes">Ver detalhes</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>

</body>
</html>